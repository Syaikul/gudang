<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Modelkeluar;
use App\Models\Modelbarang;
use App\Models\Modelclient;

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


        // Cek jika jumlah yang dimasukkan negatif
        if ($jumlahKeluar <= 0) {
            return redirect()->back()->with('error', 'Jumlah barang keluar harus lebih dari 0.');
        }
        // Ambil data barang untuk cek stok
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

        return redirect()->to('/keluar/tambahkeluar')->with('sukses', 'Data barang keluar berhasil disimpan.');
    }
    public function editkeluar($id)
    {
        // Mengambil data barang keluar berdasarkan kode transaksi
        $dataKeluar = $this->keluar
            ->select('keluar.*, barang.brgnama, client.clientnama')
            ->join('barang', 'barang.brgkode = keluar.klrbrgkode')
            ->join('client', 'client.clientid = keluar.clientid')
            ->where('keluar.klrkode', $id)
            ->first();

        if (!$dataKeluar) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data tidak ditemukan');
        }

        // Ambil semua data barang dan client untuk dropdown pilihan
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

        // Ambil data lama keluar
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

        return redirect()->to('/keluar/index')->with('sukses', 'Data barang keluar berhasil diperbarui.');
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

            session()->setFlashdata('sukses', 'Data berhasil dihapus dan stok barang dikembalikan.');
        } else {
            session()->setFlashdata('error', 'Data tidak ditemukan.');
        }

        return redirect()->to('/keluar/index');
    }
}
