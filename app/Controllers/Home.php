<?php

namespace App\Controllers;

use CodeIgniter\Database\BaseBuilder;
use App\Controllers\BaseController;
use App\Models\Modelmasuk;
use App\Models\Modelkeluar;

class Home extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();


        $query = $db->query("
        SELECT 
            masuk.msktanggal AS tanggal, 
            barang.brgnama, 
            'Masuk' AS status, 
            masuk.mskjumlah AS jumlah
        FROM masuk
        JOIN barang ON barang.brgkode = masuk.mskbrgkode

        UNION ALL

        SELECT 
            keluar.klrtanggal AS tanggal, 
            barang.brgnama, 
            'Keluar' AS status, 
            keluar.klrjumlah AS jumlah
        FROM keluar
        JOIN barang ON barang.brgkode = keluar.klrbrgkode

        ORDER BY tanggal DESC
        
    ");
        $dataGabungan = $query->getResultArray();

        // === Data untuk Chart ===
        $grafikMasuk = array_fill(1, 12, 0);
        $grafikKeluar = array_fill(1, 12, 0);

        // Barang Masuk per bulan
        $masuk = $db->query("
        SELECT MONTH(msktanggal) as bulan, SUM(mskjumlah) as total 
        FROM masuk 
        WHERE YEAR(msktanggal) = YEAR(CURDATE()) 
        GROUP BY bulan
    ")->getResultArray();
        foreach ($masuk as $row) {
            $grafikMasuk[(int) $row['bulan']] = (int) $row['total'];
        }

        // Barang Keluar per bulan
        $keluar = $db->query("
        SELECT MONTH(klrtanggal) as bulan, SUM(klrjumlah) as total 
        FROM keluar 
        WHERE YEAR(klrtanggal) = YEAR(CURDATE()) 
        GROUP BY bulan
    ")->getResultArray();
        foreach ($keluar as $row) {
            $grafikKeluar[(int) $row['bulan']] = (int) $row['total'];
        }

        return view('main/viewhome', [
            'dataGabungan' => $dataGabungan,
            'grafikMasuk' => array_values($grafikMasuk),
            'grafikKeluar' => array_values($grafikKeluar),
        ]);
    }
}
