<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Modelmasuk;
use App\Models\Modelbarang;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;


class Masuk extends BaseController
{
    protected $Modelmasuk;


    protected $masuk;

    public function __construct()
    {
        $this->masuk = new Modelmasuk();
        $this->Modelmasuk = new Modelmasuk();
    }

    public function index()
    {
        // Ambil semua data barang masuk dan join dengan tabel barang
        $dataMasuk = $this->masuk
            ->select('masuk.*, barang.brgnama')
            ->join('barang', 'barang.brgkode = masuk.mskbrgkode')
            ->orderBy('msktanggal', 'DESC')
            ->findAll();

        $data = [
            'tampildata' => $dataMasuk
        ];

        return view('masuk/viewmasuk', $data);
    }
    public function tambahmasuk()
    {
        $modelBarang = new \App\Models\Modelbarang();
        $data = [
            'barang' => $modelBarang->findAll()
        ];

        return view('masuk/tambahmasuk', $data);
    }


    public function simpanmasuk()
    {
        $kodebarang = $this->request->getVar('namabarang');
        $jumlah     = $this->request->getVar('jumlah');
        $tanggal    = $this->request->getVar('tanggal');
        $keterangan = $this->request->getVar('keterangan');

        $validation = \Config\Services::validation();

        $modelMasuk = new Modelmasuk();
        $modelBarang = new \App\Models\Modelbarang();


        $dataMasuk = [
            'mskbrgkode' => $kodebarang,
            'mskjumlah' => $jumlah,
            'msktanggal' => $tanggal,
            'mskketerangan' => $keterangan,
        ];
        $modelMasuk->insert($dataMasuk);


        $barang = $modelBarang->find($kodebarang);

        if ($barang) {
            $stokBaru = $barang['brgstok'] + $jumlah;

            $modelBarang->update($kodebarang, [
                'brgstok' => $stokBaru
            ]);
        }

        $pesan = [
            'sukses' => '<div class="alert alert-success">berhasil ditambahkan...</div>'
        ];

        session()->setFlashdata($pesan);
        return redirect()->to('/masuk/tambahmasuk');
    }



    public function editmasuk($id)
    {

        $dataMasuk = $this->masuk
            ->select('masuk.*, barang.brgnama')
            ->join('barang', 'barang.brgkode = masuk.mskbrgkode')
            ->where('masuk.mskkode', $id) // Pastikan ID yang dikirim benar
            ->first();

        if (!$dataMasuk) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data tidak ditemukan');
        }


        $modelBarang = new \App\Models\Modelbarang();
        $barang = $modelBarang->findAll();


        return view('masuk/editmasuk', [
            'dataMasuk' => $dataMasuk,
            'barang'    => $barang
        ]);
    }
    public function updatemasuk()
    {
        $id = $this->request->getVar('mskkode');
        $kodebarang = $this->request->getVar('namabarang');
        $jumlahBaru = (int) $this->request->getVar('jumlah');
        $tanggal = $this->request->getVar('tanggal');
        $keterangan = $this->request->getVar('keterangan');

        $modelMasuk = new \App\Models\Modelmasuk();
        $modelBarang = new \App\Models\Modelbarang();


        $dataLama = $modelMasuk->find($id);
        $jumlahLama = (int) $dataLama['mskjumlah'];
        $kodeBarangLama = $dataLama['mskbrgkode'];


        if ($kodebarang == $kodeBarangLama) {
            // Ambil stok sekarang
            $barang = $modelBarang->find($kodebarang);
            $stokBaru = $barang['brgstok'] - $jumlahLama + $jumlahBaru;
            $modelBarang->update($kodebarang, ['brgstok' => $stokBaru]);
        } else {
            // Jika ganti kode barang, kembalikan stok lama dulu
            $barangLama = $modelBarang->find($kodeBarangLama);
            $modelBarang->update($kodeBarangLama, [
                'brgstok' => $barangLama['brgstok'] - $jumlahLama
            ]);

            // Tambah stok ke barang baru
            $barangBaru = $modelBarang->find($kodebarang);
            $modelBarang->update($kodebarang, [
                'brgstok' => $barangBaru['brgstok'] + $jumlahBaru
            ]);
        }

        // Update tabel masuk
        $data = [
            'mskbrgkode' => $kodebarang,
            'mskjumlah' => $jumlahBaru,
            'msktanggal' => $tanggal,
            'mskketerangan' => $keterangan,
        ];
        $modelMasuk->update($id, $data);

        $pesan = [
            'sukses' => '<div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  Data barang masuk berhasil diperbarui
                </div>'
        ];

        session()->setFlashdata($pesan);
        return redirect()->to('/masuk/index');
    }


    public function hapusmasuk($id)
    {
        $modelMasuk = new \App\Models\Modelmasuk();
        $modelBarang = new \App\Models\Modelbarang();

        // Ambil data masuk berdasarkan ID
        $dataMasuk = $modelMasuk->find($id);
        if ($dataMasuk) {
            $kodebarang = $dataMasuk['mskbrgkode'];
            $jumlah = (int) $dataMasuk['mskjumlah'];

            // Kurangi stok barang
            $barang = $modelBarang->find($kodebarang);
            $stokSekarang = (int) $barang['brgstok'];
            $stokBaru = $stokSekarang - $jumlah;

            // Update stok di tabel barang
            $modelBarang->update($kodebarang, ['brgstok' => $stokBaru]);

            // Hapus data masuk
            $modelMasuk->delete($id);

            $pesan = [
                'sukses' => '<div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  Data barang masuk berhasil dihapus
                </div>'
            ];

            session()->setFlashdata($pesan);
        } else {
            session()->setFlashdata('error', 'Data tidak ditemukan.');
        }

        return redirect()->to('/masuk');
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

                $barangModel = new \App\Models\Modelbarang();
                $masukModel  = new \App\Models\Modelmasuk();

                $logGagal = [];
                $jumlahSukses = 0;

                foreach (array_slice($sheetData, 1) as $i => $row) {
                    $namaBarang = trim($row[0]);
                    $jumlah     = (int) trim($row[1]);
                    $rawTanggal = $row[2];
                    $keterangan = trim($row[3]);

                    // Konversi tanggal Excel ke format Y-m-d
                    if (is_numeric($rawTanggal)) {
                        $tanggal = Date::excelToDateTimeObject($rawTanggal)->format('Y-m-d');
                    } else {
                        $tanggal = date('Y-m-d', strtotime($rawTanggal));
                    }

                    // Validasi jumlah
                    if ($jumlah <= 0) {
                        $logGagal[] = "Baris " . ($i + 2) . ": Jumlah harus lebih dari 0.";
                        continue;
                    }

                    // Cari barang berdasarkan nama
                    $barang = $barangModel->where('brgnama', $namaBarang)->first();
                    if (!$barang) {
                        $logGagal[] = "Baris " . ($i + 2) . ": Barang '$namaBarang' tidak ditemukan.";
                        continue;
                    }

                    $kodebarang = $barang['brgkode'];


                    $insert = $masukModel->insert([
                        'mskbrgkode'    => $kodebarang,
                        'msktanggal'    => $tanggal,
                        'mskjumlah'     => $jumlah,
                        'mskketerangan' => $keterangan,
                    ]);

                    if (!$insert) {
                        $logGagal[] = "Baris " . ($i + 2) . ": Gagal insert. Error: " . json_encode($masukModel->errors());
                        continue;
                    }

                    // Update stok barang
                    $barang = $barangModel->find($kodebarang);
                    if ($barang) {
                        $stokBaru = $barang['brgstok'] + $jumlah;
                        $barangModel->update($kodebarang, ['brgstok' => $stokBaru]);
                    }

                    $jumlahSukses++;
                }

                // Beri feedback ke user
                session()->setFlashdata('sukses_excel', "$jumlahSukses data berhasil diimport.");
                if (!empty($logGagal)) {
                    session()->setFlashdata('gagal_excel', implode('<br>', $logGagal));
                }

                return redirect()->to('/masuk');
            } else {
                return redirect()->back()->with('error', 'Format file tidak valid (harus .xls, .xlsx, .csv).');
            }
        } else {
            return redirect()->back()->with('error', 'File tidak valid atau belum dipilih.');
        }
    }
}
