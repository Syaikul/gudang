<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Modelbarang;
use App\Models\Modelkeluar;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Border;


class Request extends BaseController
{
    public function index()
    {
        $modelBarang = new Modelbarang();
        $modelKeluar = new Modelkeluar();

        $barangList = $modelBarang
            ->join('level', 'level.idlevel = barang.brglevel')
            ->whereIn('barang.brglevel', [1, 2])
            ->findAll();


        foreach ($barangList as &$barang) {
            $barang['wma'] = $modelKeluar->getWMAByBarang($barang['brgkode']);
            $barang['prioritas'] = $barang['brgstok'] - $barang['wma'];
        }


        usort($barangList, function ($a, $b) {
            return $a['prioritas'] <=> $b['prioritas'];
        });


        return view('request/viewrequest', ['barangList' => $barangList]);
    }

    public function submit()
    {
        $post = $this->request->getPost();

        $selected = $post['pilih'] ?? [];
        $jumlah = $post['jumlah'] ?? [];

        if (empty($selected)) {
            return redirect()->back()->with('error', 'Pilih barang terlebih dahulu.');
        }

        $barangModel = new Modelbarang();

        $requestData = [];

        foreach ($selected as $brgkode) {
            $barang = $barangModel
                ->select('barang.*, satuan.satnama, kategori.katnama')
                ->join('satuan', 'satuan.satid = barang.brgsatid')
                ->join('kategori', 'kategori.katid = barang.brgkatid')
                ->where('brgkode', $brgkode)
                ->first();


            if ($barang) {
                $requestData[] = [
                    'nama' => $barang['brgnama'],
                    'deskripsi' => $barang['brgdeskripsi'],
                    'jumlah' => $jumlah[$brgkode] ?? 0,
                    'satuan' => $barang['satnama'],
                    'kategori' => $barang['katnama']
                ];
            }
        }

        $this->generateExcel($requestData);
    }


    private function generateExcel(array $requestData)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();


        $spreadsheet->getDefaultStyle()->getFont()->setName('Tahoma')->setSize(12);

        //  logo
        $logo = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $logo->setName('Logo');
        $logo->setPath(FCPATH . 'dist/img/mesitek.png');
        $logo->setCoordinates('A1');
        $logo->setHeight(68);
        $logo->setWorksheet($sheet);

        // Header - Logo dan Judul
        $sheet->mergeCells('A1:C4');
        $sheet->getStyle('A1:C4')->applyFromArray([
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
        ]);

        $sheet->mergeCells('D1:G2');
        $sheet->setCellValue('D1', 'Laporan Permintaan Barang');
        $sheet->getStyle('D1')->getFont()->setSize(13)->setBold(true);
        $sheet->getStyle('D1:G2')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('D1:G2')->applyFromArray([
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
        ]);

        $sheet->mergeCells('D3:G4');
        $sheet->setCellValue('D3', 'Tanggal: ' . date('d-m-Y'));
        $sheet->getStyle('D3')->getFont()->setSize(13);
        $sheet->getStyle('D3:G4')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('D3:G4')->applyFromArray([
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
        ]);

        // Tanggal Dibutuhkan
        $sheet->mergeCells('A6:E6');
        $sheet->setCellValue('A6', 'Tanggal Dibutuhkan: ' . date('d-m-Y', strtotime('+3 days')));
        $sheet->getStyle('A6:E6')->getFont()->setSize(12);
        $sheet->getStyle('A6:E6')->applyFromArray([
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
        ]);

        // Header Tabel
        $sheet->setCellValue('A8', 'No');
        $sheet->mergeCells('B8:F8')->setCellValue('B8', 'Nama Barang');
        $sheet->setCellValue('G8', 'Jumlah');
        $sheet->setCellValue('H8', 'Satuan');
        $sheet->setCellValue('I8', 'Kategori');

        $sheet->getStyle('A8:I8')->applyFromArray([
            'font' => ['bold' => true, 'size' => 12],
            'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
        ]);

        // Data Tabel
        $row = 9;
        $no = 1;

        foreach ($requestData as $item) {
            $sheet->setCellValue("A{$row}", $no++);
            $sheet->mergeCells("B{$row}:F{$row}")->setCellValue("B{$row}", $item['nama']);
            $sheet->setCellValue("G{$row}", $item['jumlah']);
            $sheet->setCellValue("H{$row}", $item['satuan']);
            $sheet->setCellValue("I{$row}", $item['kategori'] ?? '-');

            // Format dan Border
            $sheet->getStyle("A{$row}:I{$row}")->applyFromArray([
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
            ]);

            $sheet->getStyle("G{$row}")->getNumberFormat()->setFormatCode('#,##0');
            $row++;
        }

        // Auto width kolom
        foreach (range('A', 'I') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Output ke browser
        $filename = 'request_barang_' . date('Ymd_His') . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}
