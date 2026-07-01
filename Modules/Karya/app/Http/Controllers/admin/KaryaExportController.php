<?php

namespace Modules\Karya\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Modules\Karya\Models\Karya;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class KaryaExportController extends Controller
{
    public function exportExcel()
    {
        $karyas = Karya::with('user')
            ->whereIn('status_validasi', ['accepted', 'rejected'])
            ->orderBy('created_at', 'desc')
            ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Laporan Karya');

        // ========== HEADER / TITLE SECTION ==========
        $sheet->mergeCells('A1:H1');
        $sheet->setCellValue('A1', 'LAPORAN DATA KARYA MAHASISWA');
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 16, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '4F46E5']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
        ]);
        $sheet->getRowDimension(1)->setRowHeight(40);

        $sheet->mergeCells('A2:H2');
        $sheet->setCellValue('A2', 'Portal Karya Teknologi Rekayasa Perangkat Lunak \u2014 Sekolah Vokasi IPB University');
        $sheet->getStyle('A2')->applyFromArray([
            'font' => ['italic' => true, 'size' => 10, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '6366F1']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);
        $sheet->getRowDimension(2)->setRowHeight(25);

        $sheet->mergeCells('A3:H3');
        $sheet->setCellValue('A3', 'Diekspor pada: ' . now()->format('d F Y, H:i:s') . ' WIB');
        $sheet->getStyle('A3')->applyFromArray([
            'font' => ['size' => 9, 'color' => ['rgb' => '6B7280']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);
        $sheet->getRowDimension(3)->setRowHeight(20);

        // ========== COLUMN HEADERS ==========
        $columns = ['No', 'Judul Karya', 'Tahun', 'Tim Pembuat', 'Kategori', 'Status', 'Pengunggah', 'Tanggal Upload'];
        $colLetters = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];
        $headerRow = 5;

        foreach ($columns as $i => $col) {
            $sheet->setCellValue($colLetters[$i] . $headerRow, $col);
        }

        $sheet->getStyle("A{$headerRow}:H{$headerRow}")->applyFromArray([
            'font' => ['bold' => true, 'size' => 11, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1F2937']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '374151']]],
        ]);
        $sheet->getRowDimension($headerRow)->setRowHeight(30);

        // ========== DATA ROWS ==========
        $row = $headerRow + 1;
        $no = 1;
        foreach ($karyas as $karya) {
            $sheet->setCellValue("A{$row}", $no);
            $sheet->setCellValue("B{$row}", $karya->judul);
            $sheet->setCellValue("C{$row}", $karya->tahun);
            $sheet->setCellValue("D{$row}", $karya->tim_pembuat);
            $sheet->setCellValue("E{$row}", $karya->kategori ?? '-');
            $sheet->setCellValue("F{$row}", ucfirst($karya->status_validasi));
            $sheet->setCellValue("G{$row}", $karya->user->name ?? 'Unknown');
            $sheet->setCellValue("H{$row}", $karya->created_at->format('d-m-Y H:i'));

            // Alternating row colors
            $bgColor = ($no % 2 === 0) ? 'F3F4F6' : 'FFFFFF';
            $sheet->getStyle("A{$row}:H{$row}")->applyFromArray([
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $bgColor]],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'E5E7EB']]],
                'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
            ]);

            // Status color coding
            $statusColor = match($karya->status_validasi) {
                'accepted' => '10B981',
                'rejected' => 'EF4444',
                'submission' => 'F59E0B',
                default => '6B7280',
            };
            $sheet->getStyle("F{$row}")->applyFromArray([
                'font' => ['bold' => true, 'color' => ['rgb' => $statusColor]],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ]);

            $sheet->getRowDimension($row)->setRowHeight(22);
            $row++;
            $no++;
        }

        // ========== FOOTER ==========
        $footerRow = $row + 1;
        $sheet->mergeCells("A{$footerRow}:H{$footerRow}");
        $sheet->setCellValue("A{$footerRow}", "Total: {$karyas->count()} karya | \u00a9 " . date('Y') . " Portal TPL SV IPB");
        $sheet->getStyle("A{$footerRow}")->applyFromArray([
            'font' => ['italic' => true, 'size' => 9, 'color' => ['rgb' => '9CA3AF']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);

        // ========== AUTO-SIZE COLUMNS ==========
        $widths = [6, 35, 8, 25, 15, 14, 20, 18];
        foreach ($colLetters as $i => $letter) {
            $sheet->getColumnDimension($letter)->setWidth($widths[$i]);
        }

        // ========== DOWNLOAD ==========
        $filename = "laporan_karya_" . date('Y-m-d_H-i-s') . ".xlsx";
        $writer = new Xlsx($spreadsheet);

        return response()->streamDownload(function() use ($writer) {
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }
}