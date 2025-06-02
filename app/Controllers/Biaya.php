<?php

namespace App\Controllers;

use App\Models\Modelclient;
use App\Models\Modelkeluar; // asumsi data keluar barang di sini
use App\Models\Modelbarang;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Biaya extends BaseController
{
    public function index()
    {
        $modelClient = new Modelclient();
        $data['client'] = $modelClient->findAll();

        return view('biaya/viewbiaya', $data);
    }

    public function cetak()
    {
        $clientId = $this->request->getPost('clientid');
        $dariBulan = $this->request->getPost('dari_bulan');
        $sampaiBulan = $this->request->getPost('sampai_bulan');

        $modelKeluar = new Modelkeluar();

        $startDate = $dariBulan . '-01';
        $endDate = date('Y-m-t', strtotime($sampaiBulan . '-01'));

        // Ganti kode query builder lama dengan ini:
        $builder = $modelKeluar->select('keluar.klrbrgkode, barang.brgnama, barang.brgharga, SUM(keluar.klrjumlah) as total_keluar')
            ->join('barang', 'barang.brgkode = keluar.klrbrgkode')
            ->where('keluar.klrtanggal >=', $startDate)
            ->where('keluar.klrtanggal <=', $endDate)
            ->groupBy('keluar.klrbrgkode')
            ->orderBy('barang.brgnama', 'ASC');

        if (!empty($clientId)) {
            $builder->where('keluar.clientid', $clientId);
        }

        $dataBarang = $builder->get()->getResultArray();

        // Generate Excel file
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header kolom
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama Barang');
        $sheet->setCellValue('C1', 'Harga per Unit');
        $sheet->setCellValue('D1', 'Total Pengeluaran Barang (Qty)');
        $sheet->setCellValue('E1', 'Total Harga');

        $row = 2;
        $no = 1;
        $totalHargaKeseluruhan = 0;

        foreach ($dataBarang as $item) {
            $totalHarga = $item['brgharga'] * $item['total_keluar'];
            $totalHargaKeseluruhan += $totalHarga;

            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, $item['brgnama']);
            $sheet->setCellValue('C' . $row, $item['brgharga']);
            $sheet->setCellValue('D' . $row, $item['total_keluar']);
            $sheet->setCellValue('E' . $row, $totalHarga);

            $sheet->getStyle('C' . $row)
                ->getNumberFormat()
                ->setFormatCode('#,##0');

            $sheet->getStyle('E' . $row)
                ->getNumberFormat()
                ->setFormatCode('#,##0');
            $row++;
        }

        // Total keseluruhan di bawah
        $sheet->setCellValue('D' . $row, 'Total Keseluruhan');
        $sheet->setCellValue('E' . $row, $totalHargaKeseluruhan);


        $sheet->getStyle('E' . $row)
            ->getNumberFormat()
            ->setFormatCode('#,##0');

        // Header HTTP untuk download file Excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="rekap_biaya_barang.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}
