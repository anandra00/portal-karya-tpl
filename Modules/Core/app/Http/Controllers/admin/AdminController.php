<?php

namespace Modules\Core\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // LIST ADMIN
    public function index()
    {
        $admins = User::where('role', 'admin')->get();
        return view('admin.admin-users.list', compact('admins'));
    }

    // FORM TAMBAH ADMIN
    public function create()
    {
        return view('admin.admin-users.create');
    }

    // SIMPAN ADMIN BARU
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => 'admin',
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('admin.list')->with('success', 'Admin berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        // Cegah admin menghapus akun sendiri
        if ($id == auth()->id()) {
            return back()->with('error', 'Tidak bisa menghapus akun sendiri.');
        }

        User::where('id', $id)->delete();
        return back()->with('success', 'Admin dihapus.');
    }

    // LIHAT PENGUNJUNG
    public function lihatPengunjung(Request $request)
    {
        $users = User::where('role', 'user')->orderBy('created_at', 'desc')->get();
        
        // Paginate visitors logs
        $visitors = \Modules\Core\Models\Visitor::orderBy('visited_at', 'desc')->paginate(15, ['*'], 'page_visitors');
        
        return view('admin.pengunjung.index', compact('users', 'visitors'));
    }

    // HAPUS SEMUA LOG KUNJUNGAN (Untuk Reset Dummy Data)
    public function clearVisitorLogs()
    {
        \Modules\Core\Models\Visitor::truncate();
        return redirect()->route('lihatpengunjung')->with('success', 'Semua log kunjungan berhasil dihapus!');
    }

    // EXPORT PENGUNJUNG ke Excel (.xlsx) dengan template premium
    public function exportPengunjung()
    {
        $users = User::where('role', 'user')->get();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Laporan Pengunjung');

        // ========== HEADER ==========
        $sheet->mergeCells('A1:E1');
        $sheet->setCellValue('A1', 'LAPORAN DATA PENGUNJUNG');
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 16, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '4F46E5']],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, 'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER],
        ]);
        $sheet->getRowDimension(1)->setRowHeight(40);

        $sheet->mergeCells('A2:E2');
        $sheet->setCellValue('A2', 'Portal Karya Teknologi Rekayasa Perangkat Lunak — Sekolah Vokasi IPB University');
        $sheet->getStyle('A2')->applyFromArray([
            'font' => ['italic' => true, 'size' => 10, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '6366F1']],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ]);
        $sheet->getRowDimension(2)->setRowHeight(25);

        $sheet->mergeCells('A3:E3');
        $sheet->setCellValue('A3', 'Diekspor pada: ' . now()->format('d F Y, H:i:s') . ' WIB');
        $sheet->getStyle('A3')->applyFromArray([
            'font' => ['size' => 9, 'color' => ['rgb' => '6B7280']],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ]);

        // ========== COLUMN HEADERS ==========
        $columns = ['No', 'Nama', 'Email', 'Role', 'Tanggal Mendaftar'];
        $colLetters = ['A', 'B', 'C', 'D', 'E'];
        $headerRow = 5;

        foreach ($columns as $i => $col) {
            $sheet->setCellValue($colLetters[$i] . $headerRow, $col);
        }

        $sheet->getStyle("A{$headerRow}:E{$headerRow}")->applyFromArray([
            'font' => ['bold' => true, 'size' => 11, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '1F2937']],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, 'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER],
            'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['rgb' => '374151']]],
        ]);
        $sheet->getRowDimension($headerRow)->setRowHeight(30);

        // ========== DATA ROWS ==========
        $row = $headerRow + 1;
        $no = 1;
        foreach ($users as $user) {
            $sheet->setCellValue("A{$row}", $no);
            $sheet->setCellValue("B{$row}", $user->name);
            $sheet->setCellValue("C{$row}", $user->email);
            $sheet->setCellValue("D{$row}", ucfirst($user->role));
            $sheet->setCellValue("E{$row}", $user->created_at->format('d-m-Y H:i'));

            $bgColor = ($no % 2 === 0) ? 'F3F4F6' : 'FFFFFF';
            $sheet->getStyle("A{$row}:E{$row}")->applyFromArray([
                'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => $bgColor]],
                'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['rgb' => 'E5E7EB']]],
                'alignment' => ['vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER],
            ]);
            $sheet->getRowDimension($row)->setRowHeight(22);
            $row++;
            $no++;
        }

        // ========== FOOTER ==========
        $footerRow = $row + 1;
        $sheet->mergeCells("A{$footerRow}:E{$footerRow}");
        $sheet->setCellValue("A{$footerRow}", "Total: {$users->count()} pengguna | © " . date('Y') . " Portal TPL SV IPB");
        $sheet->getStyle("A{$footerRow}")->applyFromArray([
            'font' => ['italic' => true, 'size' => 9, 'color' => ['rgb' => '9CA3AF']],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ]);

        // ========== COLUMN WIDTHS ==========
        $widths = [6, 25, 30, 12, 20];
        foreach ($colLetters as $i => $letter) {
            $sheet->getColumnDimension($letter)->setWidth($widths[$i]);
        }

        // ========== DOWNLOAD ==========
        $filename = "laporan_pengunjung_" . date('Y-m-d_H-i-s') . ".xlsx";
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

        return response()->streamDownload(function() use ($writer) {
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }
}
