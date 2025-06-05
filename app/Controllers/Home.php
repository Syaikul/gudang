<?php

namespace App\Controllers;

use App\Models\Modelmasuk;
use App\Models\Modelkeluar;
use App\Models\Modelbarang;

class Home extends BaseController
{
    public function index()
    {
        $modelMasuk = new Modelmasuk();
        $modelKeluar = new Modelkeluar();
        $modelBarang = new Modelbarang();

        $dataMasuk = $modelMasuk->select("MONTH(msktanggal) AS bulan, SUM(mskjumlah) AS total")
            ->groupBy("bulan")
            ->orderBy("bulan", "ASC")
            ->findAll();

        $dataKeluar = $modelKeluar->select("MONTH(klrtanggal) AS bulan, SUM(klrjumlah) AS total")
            ->groupBy("bulan")
            ->orderBy("bulan", "ASC")
            ->findAll();

        $grafikMasuk = array_fill(1, 12, 0);
        $grafikKeluar = array_fill(1, 12, 0);

        foreach ($dataMasuk as $row) {
            $grafikMasuk[(int)$row['bulan']] = (int)$row['total'];
        }

        foreach ($dataKeluar as $row) {
            $grafikKeluar[(int)$row['bulan']] = (int)$row['total'];
        }

        $queryMasuk = $modelMasuk
            ->select("mskbrgkode AS kode, msktanggal AS tanggal, mskjumlah AS jumlah, 'Masuk' AS status")
            ->orderBy('msktanggal', 'DESC')
            ->findAll(5);

        $queryKeluar = $modelKeluar
            ->select("klrbrgkode AS kode, klrtanggal AS tanggal, klrjumlah AS jumlah, 'Keluar' AS status")
            ->orderBy('klrtanggal', 'DESC')
            ->findAll(5);

        $aktivitas = array_merge($queryMasuk, $queryKeluar);

        usort($aktivitas, fn($a, $b) => strtotime($b['tanggal']) - strtotime($a['tanggal']));

        foreach ($aktivitas as &$row) {
            $barang = $modelBarang->find($row['kode']);
            $row['nama'] = $barang['brgnama'] ?? 'Tidak diketahui';
        }

        // DEBUG: tampilkan aktivitas dulu
        echo "<pre>";
        print_r($aktivitas);
        echo "</pre>";
        exit;

        return view('main/viewhome', [
            'grafikMasuk' => $grafikMasuk,
            'grafikKeluar' => $grafikKeluar,
            'aktivitas' => array_slice($aktivitas, 0, 5),
        ]);
    }
}
