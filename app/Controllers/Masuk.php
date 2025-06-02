<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Modelmasuk;
use App\Models\Modelbarang;


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
            ->orderBy('msktanggal', 'DESC') // Urutkan berdasarkan tanggal masuk
            ->findAll(); // Mengambil semua data masuk tanpa pagination

        $data = [
            'tampildata' => $dataMasuk
        ];

        return view('masuk/viewmasuk', $data);
    }
    public function tambahmasuk()
    {
        $modelBarang = new \App\Models\Modelbarang();
        $data = [
            'barang' => $modelBarang->findAll() // ⬅ ubah 'databarang' jadi 'barang'
        ];

        return view('masuk/tambahmasuk', $data);
    }


    public function simpanmasuk()
    {
        $kodebarang = $this->request->getVar('namabarang');
        $jumlah     = $this->request->getVar('jumlah');
        $tanggal    = $this->request->getVar('tanggal');
        $keterangan = $this->request->getVar('keterangan'); // <- kecil semua, perhatikan ini

        $validation = \Config\Services::validation();

        $modelMasuk = new Modelmasuk();
        $modelBarang = new \App\Models\Modelbarang();

        // Simpan ke tabel 'masuk'
        $dataMasuk = [
            'mskbrgkode' => $kodebarang,
            'mskjumlah' => $jumlah,
            'msktanggal' => $tanggal,
            'mskketerangan' => $keterangan,
        ];
        $modelMasuk->insert($dataMasuk);

        // Tambahkan jumlah ke stok barang
        $barang = $modelBarang->find($kodebarang); // cari barang berdasarkan kode

        if ($barang) {
            $stokBaru = $barang['brgstok'] + $jumlah;

            $modelBarang->update($kodebarang, [
                'brgstok' => $stokBaru
            ]);
        }

        return redirect()->to('/masuk/index')->with('sukses', 'Data barang masuk berhasil disimpan dan stok diperbarui.');
    }



    public function editmasuk($id)
    {
        // Mengambil data barang masuk berdasarkan kode transaksi
        $dataMasuk = $this->masuk
            ->select('masuk.*, barang.brgnama')
            ->join('barang', 'barang.brgkode = masuk.mskbrgkode')
            ->where('masuk.mskkode', $id) // Pastikan ID yang dikirim benar
            ->first();

        if (!$dataMasuk) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data tidak ditemukan');
        }

        // Ambil semua data barang untuk pilihan di dropdown
        $modelBarang = new \App\Models\Modelbarang();
        $barang = $modelBarang->findAll();

        // Kirim data ke view
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

        // Ambil data masuk lama
        $dataLama = $modelMasuk->find($id);
        $jumlahLama = (int) $dataLama['mskjumlah'];
        $kodeBarangLama = $dataLama['mskbrgkode'];

        // Jika barangnya sama:
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

        session()->setFlashdata('sukses', 'Data barang masuk berhasil diperbarui dan stok disesuaikan.');
        return redirect()->to('/masuk');
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

            session()->setFlashdata('sukses', 'Data berhasil dihapus dan stok barang dikurangi.');
        } else {
            session()->setFlashdata('error', 'Data tidak ditemukan.');
        }

        return redirect()->to('/masuk');
    }
}
