# 🧠 PhpSpreadsheet - Premium Excel Exports

Aplikasi ini menggunakan package `phpoffice/phpspreadsheet` untuk memfasilitasi ekspor data statistik (seperti daftar karya dan data kunjungan pengunjung) ke format spreadsheet `.xlsx` dengan tampilan visual yang di-styling premium (bukan plain unstyled grid).

---

## 1. Panduan Styling Premium Excel

Agar laporan ekspor terlihat premium dan nyaman dibaca oleh pihak akademik/manajemen, terapkan prinsip styling spreadsheet berikut:
- **Title Header**: Gunakan sel gabungan (`mergeCells`) dengan warna latar belakang solid gelap (misalnya indigo atau abu-abu tua) dan warna teks putih tebal.
- **Row Height**: Berikan ruang bernapas yang cukup dengan menambah tinggi baris (misal header 30px, baris data 22px).
- **Zebra Striping**: Gunakan warna latar belakang baris berseling (misal baris genap abu-abu sangat muda `#F3F4F6`, baris ganjil putih `#FFFFFF`) untuk memudahkan pemindaian data.
- **Auto Width / Custom Width**: Atur lebar kolom secara manual agar data tidak terpotong (jangan biarkan kolom default Excel).

---

## 2. Contoh Kode Implementasi

Metode ekspor pengunjung didefinisikan di kelas [AdminController.php](file:///c:/laragon/www/PJBL-EUYY/Modules/Core/app/Http/Controllers/admin/AdminController.php#L75-L171):

```php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Laporan Pengunjung');

// 1. Styling Merge Title Header
$sheet->mergeCells('A1:E1');
$sheet->setCellValue('A1', 'LAPORAN DATA PENGUNJUNG');
$sheet->getStyle('A1')->applyFromArray([
    'font' => ['bold' => true, 'size' => 16, 'color' => ['rgb' => 'FFFFFF']],
    'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '4F46E5']], // Indigo solid background
    'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, 'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER],
]);
$sheet->getRowDimension(1)->setRowHeight(40);

// 2. Tulis Data & Zebra Striping
$row = 6;
$no = 1;
foreach ($users as $user) {
    $sheet->setCellValue("A{$row}", $no);
    $sheet->setCellValue("B{$row}", $user->name);
    // ...
    
    $bgColor = ($no % 2 === 0) ? 'F3F4F6' : 'FFFFFF'; // Zebra striping
    $sheet->getStyle("A{$row}:E{$row}")->applyFromArray([
        'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => $bgColor]],
        'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['rgb' => 'E5E7EB']]],
    ]);
    $row++;
    $no++;
}

// 3. Stream Download ke Browser
$filename = "laporan_pengunjung_" . date('Y-m-d') . ".xlsx";
$writer = new Xlsx($spreadsheet);

return response()->streamDownload(function() use ($writer) {
    $writer->save('php://output');
}, $filename, [
    'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
]);
```
Layanan ekspor ini terintegrasi langsung pada menu panel admin di rute `/admin/export-pengunjung` dan `/admin/karya/export`.
