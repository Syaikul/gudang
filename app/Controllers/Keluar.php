<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Modelkeluar;
use App\Models\Modelbarang;
use App\Models\Modelclient;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Keluar extends BaseController
{
    protected $keluar;

    public function __construct()
    {
        $this->keluar = new Modelkeluar();
    }

    public function index()
    {
        $dataKeluar = $this->keluar
            ->select('keluar.*, barang.brgnama, client.clientnama')
            ->join('barang', 'barang.brgkode = keluar.klrbrgkode')
            ->join('client', 'client.clientid = keluar.clientid')
            ->orderBy('klrtanggal', 'DESC')
            ->findAll();

        $data = [
            'tampildata' => $dataKeluar
        ];

        return view('keluar/viewkeluar', $data);
    }

    public function tambahkeluar()
    {
        $modelBarang = new Modelbarang();
        $modelClient = new Modelclient();

        $data = [
            'barang' => $modelBarang->findAll(),
            'client' => $modelClient->findAll()
        ];

        return view('keluar/tambahkeluar', $data);
    }

    public function simpankeluar()
    {
        $barangModel = new \App\Models\Modelbarang();

        $kodeBarang = $this->request->getPost('namabarang');
        $jumlahKeluar = (int) $this->request->getPost('jumlah');



        if ($jumlahKeluar <= 0) {
            return redirect()->back()->with('error', 'Jumlah barang keluar harus lebih dari 0.');
        }

        $barang = $barangModel->find($kodeBarang);

        if (!$barang) {
            return redirect()->back()->with('error', 'Barang tidak ditemukan.');
        }

        // Cek apakah stok cukup
        if ($jumlahKeluar > $barang['brgstok']) {
            return redirect()->back()->with('error', 'Jumlah keluar melebihi stok yang tersedia!');
        }

        // Kurangi stok
        $barangModel->update($kodeBarang, [
            'brgstok' => $barang['brgstok'] - $jumlahKeluar
        ]);

        // Simpan data keluar
        $this->keluar->insert([
            'klrbrgkode'    => $kodeBarang,
            'klrtanggal'    => $this->request->getPost('tanggal'),
            'klrjumlah'     => $jumlahKeluar,
            'clientid'      => $this->request->getPost('clientid'),
            'klrketerangan' => $this->request->getPost('keterangan'),
        ]);

        $pesan = [
            'sukses' => '<div class="alert alert-success">berhasil ditambahkan...</div>'
        ];

        session()->setFlashdata($pesan);
        return redirect()->to('/keluar/tambahkeluar');
    }
    public function editkeluar($id)
    {

        $dataKeluar = $this->keluar
            ->select('keluar.*, barang.brgnama, client.clientnama')
            ->join('barang', 'barang.brgkode = keluar.klrbrgkode')
            ->join('client', 'client.clientid = keluar.clientid')
            ->where('keluar.klrkode', $id)
            ->first();

        if (!$dataKeluar) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data tidak ditemukan');
        }


        $modelBarang = new \App\Models\Modelbarang();
        $modelClient = new \App\Models\Modelclient();

        $data = [
            'dataKeluar' => $dataKeluar,
            'barang'     => $modelBarang->findAll(),
            'client'     => $modelClient->findAll()
        ];

        return view('keluar/editkeluar', $data);
    }

    public function updatekeluar()
    {
        $id = $this->request->getPost('klrkode');
        $kodeBarang = $this->request->getPost('namabarang');
        $clientId = $this->request->getPost('clientid');
        $jumlahBaru = (int) $this->request->getPost('jumlah');
        $tanggal = $this->request->getPost('tanggal');
        $keterangan = $this->request->getPost('keterangan');

        $modelKeluar = new \App\Models\Modelkeluar();
        $modelBarang = new \App\Models\Modelbarang();


        $dataLama = $modelKeluar->find($id);
        if (!$dataLama) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        $jumlahLama = (int) $dataLama['klrjumlah'];
        $kodeBarangLama = $dataLama['klrbrgkode'];

        if ($kodeBarang == $kodeBarangLama) {
            // Ambil stok awal barang
            $barang = $modelBarang->find($kodeBarang);
            $stokAwal = $barang['brgstok'];

            // Hitung stok baru
            $stokBaru = $stokAwal + $jumlahLama - $jumlahBaru;

            if ($stokBaru < 0) {
                return redirect()->back()->with('error', 'Stok tidak cukup untuk update jumlah keluar.');
            }

            // Update stok
            $modelBarang->update($kodeBarang, ['brgstok' => $stokBaru]);
        } else {
            // Kalau ganti barang, rollback stok lama dulu
            $barangLama = $modelBarang->find($kodeBarangLama);
            $modelBarang->update($kodeBarangLama, [
                'brgstok' => $barangLama['brgstok'] + $jumlahLama
            ]);

            // Kurangi stok barang baru
            $barangBaru = $modelBarang->find($kodeBarang);
            if ($barangBaru['brgstok'] < $jumlahBaru) {
                return redirect()->back()->with('error', 'Stok barang baru tidak cukup.');
            }

            $modelBarang->update($kodeBarang, [
                'brgstok' => $barangBaru['brgstok'] - $jumlahBaru
            ]);
        }

        // Update data keluar
        $dataUpdate = [
            'klrbrgkode'    => $kodeBarang,
            'clientid'      => $clientId,
            'klrjumlah'     => $jumlahBaru,
            'klrtanggal'    => $tanggal,
            'klrketerangan' => $keterangan,
        ];

        $modelKeluar->update($id, $dataUpdate);

        $pesan = [
            'sukses' => '<div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  Data barang Keluar berhasil diperbarui
                </div>'
        ];

        session()->setFlashdata($pesan);
        return redirect()->to('/keluar/index');
    }

    public function hapuskeluar($id)
    {
        $modelKeluar = new \App\Models\Modelkeluar();
        $modelBarang = new \App\Models\Modelbarang();

        // Ambil data keluar berdasarkan ID
        $dataKeluar = $modelKeluar->find($id);
        if ($dataKeluar) {
            $kodeBarang = $dataKeluar['klrbrgkode'];
            $jumlahKeluar = (int) $dataKeluar['klrjumlah'];

            // Ambil data barang untuk update stok
            $barang = $modelBarang->find($kodeBarang);
            if ($barang) {
                $stokSekarang = (int) $barang['brgstok'];

                // Tambah stok kembali sesuai jumlah yang dihapus
                $stokBaru = $stokSekarang + $jumlahKeluar;

                // Update stok di tabel barang
                $modelBarang->update($kodeBarang, ['brgstok' => $stokBaru]);
            }

            // Hapus data keluar
            $modelKeluar->delete($id);

            $pesan = [
                'sukses' => '<div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  Data barang keluar berhasil dihapus
                </div>'
            ];

            session()->setFlashdata($pesan);
        } else {
            session()->setFlashdata('error', 'Data tidak ditemukan.');
        }

        return redirect()->to('/keluar/index');
    }

    public function formImport()
    {
        return view('keluar/importexcel');
    }

    public function importExcel()
    {
        $file = $this->request->getFile('fileexcel');

        if ($file->isValid() && !$file->hasMoved()) {
            $ext = $file->getClientExtension();

            if (in_array($ext, ['xls', 'xlsx', 'csv'])) {
                $reader = IOFactory::createReaderForFile($file->getTempName());
                $spreadsheet = $reader->load($file->getTempName());
                $sheetData = $spreadsheet->getActiveSheet()->toArray();

                $barangModel = new Modelbarang();
                $clientModel = new Modelclient();
                $keluarModel = new Modelkeluar();

                $logGagal = [];
                $jumlahSukses = 0;

                foreach (array_slice($sheetData, 1) as $i => $row) {
                    $namaBarang = trim($row[0]);
                    $tanggal    = trim($row[1]);
                    $jumlah     = (int) $row[2];
                    $namaClient = trim($row[3]);
                    $keterangan = trim($row[4]);

                    // Cari barang berdasarkan nama
                    $barang = $barangModel->where('brgnama', $namaBarang)->first();
                    if (!$barang) {
                        $logGagal[] = "Baris " . ($i + 2) . ": Barang '$namaBarang' tidak ditemukan.";
                        continue;
                    }

                    // Cari client berdasarkan nama
                    $client = $clientModel->where('clientnama', $namaClient)->first();
                    if (!$client) {
                        $logGagal[] = "Baris " . ($i + 2) . ": Client '$namaClient' tidak ditemukan.";
                        continue;
                    }

                    // Cek jumlah valid
                    if ($jumlah <= 0) {
                        $logGagal[] = "Baris " . ($i + 2) . ": Jumlah harus lebih dari 0.";
                        continue;
                    }

                    // Cek stok cukup
                    if ($jumlah > $barang['brgstok']) {
                        $logGagal[] = "Baris " . ($i + 2) . ": Stok '$namaBarang' tidak cukup.";
                        continue;
                    }

                    // Update stok barang
                    $barangModel->update($barang['brgkode'], [
                        'brgstok' => $barang['brgstok'] - $jumlah
                    ]);

                    // Simpan ke tabel keluar
                    $keluarModel->insert([
                        'klrbrgkode'    => $barang['brgkode'],
                        'klrtanggal'    => $tanggal,
                        'klrjumlah'     => $jumlah,
                        'clientid'      => $client['clientid'],
                        'klrketerangan' => $keterangan,
                    ]);

                    $jumlahSukses++;
                }

                // Feedback ke user
                session()->setFlashdata('sukses_excel', "$jumlahSukses data berhasil diimport.");
                if (!empty($logGagal)) {
                    session()->setFlashdata('gagal_excel', implode('<br>', $logGagal));
                }

                return redirect()->to('/keluar');
            } else {
                return redirect()->back()->with('error', 'Format file tidak valid (harus .xls, .xlsx, .csv).');
            }
        } else {
            return redirect()->back()->with('error', 'File tidak valid atau belum dipilih.');
        }
    }
}
