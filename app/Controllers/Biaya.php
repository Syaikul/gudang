<?php

namespace App\Controllers;

use App\Models\Modelclient;
use App\Models\Modelkeluar;
use App\Models\Modelbarang;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Border;




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

        $modelClient = new \App\Models\Modelclient();
        $namaClient = $clientId ? $modelClient->find($clientId)['clientnama'] : 'Semua Client';

        $modelKeluar = new \App\Models\Modelkeluar();
        $startDate = $dariBulan . '-01';
        $endDate = date('Y-m-t', strtotime($sampaiBulan . '-01'));

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

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Default font: Tahoma 12
        $spreadsheet->getDefaultStyle()->getFont()->setName('Tahoma')->setSize(12);

        // Tambahkan logo
        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setName('Logo');
        $drawing->setPath(ROOTPATH . 'public/dist/img/mesitek.png');
        $drawing->setCoordinates('A1');
        $drawing->setHeight(70);
        $drawing->setWorksheet($sheet);

        // Merge area gambar
        $sheet->mergeCells('A1:C4');

        // Judul laporan
        $sheet->mergeCells('D1:G2');
        $sheet->setCellValue('D1', 'Laporan Biaya Pengeluaran');
        $sheet->getStyle('D1')->getFont()->setSize(13)->setBold(true);
        $sheet->getStyle('D1')->getAlignment()->setHorizontal('center')->setVertical('center');

        // Periode laporan
        $periode = date('F Y', strtotime($dariBulan . '-01')) . ' - ' . date('F Y', strtotime($sampaiBulan . '-01'));
        $sheet->mergeCells('D3:G4');
        $sheet->setCellValue('D3', $periode);
        $sheet->getStyle('D3')->getFont()->setSize(13)->setItalic(true);
        $sheet->getStyle('D3')->getAlignment()->setHorizontal('center')->setVertical('center');

        // Total pengeluaran
        $totalHargaKeseluruhan = array_sum(array_map(function ($item) {
            return $item['brgharga'] * $item['total_keluar'];
        }, $dataBarang));

        $sheet->mergeCells('H1:J2');
        $sheet->setCellValue('H1', 'Total Pengeluaran');
        $sheet->getStyle('H1')->getFont()->setSize(13)->setBold(true);
        $sheet->getStyle('H1')->getAlignment()->setHorizontal('center')->setVertical('center');

        $sheet->mergeCells('H3:J4');
        $sheet->setCellValue('H3', $totalHargaKeseluruhan);
        $sheet->getStyle('H3')->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('H3')->getAlignment()->setHorizontal('center')->setVertical('center');

        // Nama client
        $sheet->mergeCells('A6:H6');
        $sheet->setCellValue('A6', 'Client: ' . $namaClient);
        $sheet->getStyle('A6')->getFont()->setBold(true);

        // Header tabel
        $sheet->setCellValue('A8', 'No');
        $sheet->mergeCells('B8:F8');
        $sheet->setCellValue('B8', 'Nama Barang');
        $sheet->mergeCells('G8:H8');
        $sheet->setCellValue('G8', 'Harga per Unit');
        $sheet->mergeCells('I8:K8');
        $sheet->setCellValue('I8', 'Total Pengeluaran');
        $sheet->mergeCells('L8:M8');
        $sheet->setCellValue('L8', 'Total Harga');

        // Style header tabel
        $sheet->getStyle('A8:M8')->getFont()->setBold(true);
        $sheet->getStyle('A8:M8')->getAlignment()->setHorizontal('center')->setVertical('center');

        // Data
        $row = 9;
        $no = 1;
        foreach ($dataBarang as $item) {
            $totalHarga = $item['brgharga'] * $item['total_keluar'];

            $sheet->setCellValue("A{$row}", $no++);
            $sheet->mergeCells("B{$row}:F{$row}");
            $sheet->setCellValue("B{$row}", $item['brgnama']);
            $sheet->getStyle("B{$row}")->getAlignment()->setHorizontal('left');

            $sheet->mergeCells("G{$row}:H{$row}");
            $sheet->setCellValue("G{$row}", $item['brgharga']);
            $sheet->getStyle("G{$row}")->getNumberFormat()->setFormatCode('#,##0');

            $sheet->mergeCells("I{$row}:K{$row}");
            $sheet->setCellValue("I{$row}", $item['total_keluar']);

            $sheet->mergeCells("L{$row}:M{$row}");
            $sheet->setCellValue("L{$row}", $totalHarga);
            $sheet->getStyle("L{$row}")->getNumberFormat()->setFormatCode('#,##0');


            $sheet->getStyle("A{$row}")->getAlignment()->setHorizontal('center');
            $sheet->getStyle("G{$row}:M{$row}")->getAlignment()->setHorizontal('center');

            $row++;
        }

        // Border seluruh area
        $borderStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ]
            ]
        ];

        // Border untuk area isi konten
        $sheet->getStyle("A1:C4")->applyFromArray($borderStyle);
        $sheet->getStyle("D1:G2")->applyFromArray($borderStyle);
        $sheet->getStyle("D3:G4")->applyFromArray($borderStyle);
        $sheet->getStyle("H1:J2")->applyFromArray($borderStyle);
        $sheet->getStyle("H3:J4")->applyFromArray($borderStyle);
        $sheet->getStyle("A6:H6")->applyFromArray($borderStyle);
        $sheet->getStyle("A8:M8")->applyFromArray($borderStyle);
        $sheet->getStyle("A9:M" . ($row - 1))->applyFromArray($borderStyle);

        // Kolom auto-size
        foreach (range('A', 'M') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Output
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="laporan_biaya_pengeluaran.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}
