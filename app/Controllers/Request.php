<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Modelbarang;
use App\Models\Modelkeluar;
use App\Models\BarangModel;
use App\Models\SatuanModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;


class Request extends BaseController
{
    public function index()
    {
        $modelBarang = new Modelbarang();
        $modelKeluar = new Modelkeluar();

        $barangList = $modelBarang->findAll();

        foreach ($barangList as &$barang) {
            $barang['wma'] = $modelKeluar->getWMAByBarang($barang['brgkode']);
            $barang['prioritas'] = $barang['brgstok'] - $barang['wma'];
        }

        // Urutkan berdasarkan prioritas naik (semakin minus = semakin butuh)
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
                ->select('barang.*, satuan.satnama')
                ->join('satuan', 'satuan.satid = barang.brgsatid')
                ->where('brgkode', $brgkode)
                ->first();

            if ($barang) {
                $requestData[] = [
                    'nama' => $barang['brgnama'],
                    'deskripsi' => $barang['brgdeskripsi'],
                    'jumlah' => $jumlah[$brgkode] ?? 0,
                    'satuan' => $barang['satnama'],
                ];
            }
        }

        $this->generateExcel($requestData);
    }


    private function generateExcel(array $requestData)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Judul besar di A1
        $sheet->setCellValue('A1', 'Laporan Request Barang');
        $sheet->mergeCells('A1:E1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);

        // Tanggal laporan di A2
        $sheet->setCellValue('A2', 'Tanggal: ' . date('d-m-Y'));
        $sheet->mergeCells('A2:E2');

        // Header mulai di baris 4
        $sheet->setCellValue('A4', 'NO');
        $sheet->setCellValue('B4', 'Jenis Permintaan');
        $sheet->setCellValue('C4', 'Spesifikasi');
        $sheet->setCellValue('D4', 'Jumlah');
        $sheet->setCellValue('E4', 'Satuan');

        // Styling header
        $sheet->getStyle('A4:E4')->getFont()->setBold(true);
        $sheet->getStyle('A4:E4')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFCCCCCC');

        // Data mulai dari baris 5
        $row = 5;
        $no = 1;
        foreach ($requestData as $item) {
            $sheet->setCellValue("A$row", $no++);
            $sheet->setCellValue("B$row", $item['nama']);
            $sheet->setCellValue("C$row", $item['deskripsi']);
            $sheet->setCellValue("D$row", $item['jumlah']);
            $sheet->setCellValue("E$row", $item['satuan']);

            $sheet->getStyle('D' . $row)
                ->getNumberFormat()
                ->setFormatCode('#,##0');
            $row++;
        }

        // Lebarkan semua kolom
        foreach (range('A', 'E') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        // Tambahkan border
        $lastRow = $row - 1;
        $sheet->getStyle("A4:E$lastRow")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ]);

        $writer = new Xlsx($spreadsheet);
        $filename = 'request_barang_' . date('Ymd_His') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }
}
