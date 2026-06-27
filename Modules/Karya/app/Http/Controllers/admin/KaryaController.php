<?php

namespace Modules\Karya\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Modules\Karya\Models\Karya;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Modules\Karya\Http\Requests\StoreKaryaRequest;
use Modules\Karya\Http\Requests\UpdateKaryaRequest;

class KaryaController extends Controller
{
    // ============================================
    // UNTUK USER BIASA (Frontend)
    // ============================================

    // Tampilkan semua karya yang ACCEPTED dengan search & filter
    public function karyaUser(Request $request)
    {
        $query = Karya::where('status_validasi', 'accepted')
                      ->with('reviews');

        $search = $request->input('search') ?? $request->input('judul');

        // Filter berdasarkan search
        if (!is_null($search) && $search !== '') {
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                  ->orWhere('tim_pembuat', 'like', '%' . $search . '%')
                  ->orWhere('kategori', 'like', '%' . $search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $search . '%');
            });
        }

        // Filter berdasarkan kategori
        if ($request->has('kategori') && $request->kategori != '') {
            $query->where('kategori', $request->kategori);
        }

        $karyas = $query->orderBy('created_at', 'desc')->get();

        // Using variable name $karya as that was used in the previous closure
        $karya = $karyas;
        $categories = \Modules\Karya\Models\Kategori::all();
        return view('pages.karya', compact('karya', 'categories'));
    }

    // Detail karya
    public function userShow(string $id)
    {
        $karya = Karya::with('reviews.user')->findOrFail($id);
        $review = $karya->reviews;

        // Cek apakah karya sudah ACCEPTED
        if ($karya->status_validasi !== 'accepted') {
            return redirect()->route('home')
                           ->with('error', 'Karya ini belum disetujui atau tidak tersedia.');
        }

        return view('pages.detailkarya', compact('karya', 'review'));
    }

    // ============================================
    // UNTUK ADMIN (Backend)
    // ============================================

    // Admin - lihat semua karya
    public function index()
    {
        $karyas = Karya::with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        $trashed = Karya::onlyTrashed()
            ->orderBy('deleted_at', 'desc')
            ->get();

        return view('admin.karya.lihatkarya', compact('karyas', 'trashed'));
    }

    public function store(StoreKaryaRequest $request)
    {
        // ambil role user
        $role = Auth::user()->role;

        $validated = $request->validated();

        // 2. Upload gambar & dokumen
        $gambarPath = null;
        if ($request->hasFile('preview_karya')) {
            $gambarPath = $this->compressAndStoreImage($request->file('preview_karya'), 'karya');
        }

        $filePath = null;
        if ($request->hasFile('file_karya')) {
            $filePath = $request->file('file_karya')->store('karya_files', 'public');
        }

        // 3. Simpan ke database
        Karya::create([
            'user_id' => Auth::id(),
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'],
            'kategori' => $validated['kategori'],
            'tahun' => $validated['tahun'],
            'preview_karya' => $gambarPath,
            'file_karya' => $filePath,
            'tim_pembuat' => $validated['tim_pembuat'],
            'link_pengumpulan' => $validated['link'],
            'status_validasi' => 'submission',
            'tanggal_upload' => now(),
        ]);

        // 4. Redirect dengan pesan sukses
        if ($role === 'admin') {
            return redirect()->route('karya.index')
                ->with('success', 'Karya berhasil ditambahkan!');
        }

        return redirect()->route('unggah')
            ->with('success', 'Karya berhasil diunggah! Menunggu validasi admin.');
    }

    // Admin - form tambah karya
    public function create()
    {
        $categories = \Modules\Karya\Models\Kategori::all();
        return view('admin.karya.create', compact('categories'));
    }

    // Admin - lihat detail karya
    public function show(string $id)
    {
        $karya = Karya::with(['user', 'reviews.user'])->findOrFail($id);
        return view('admin.karya.show', compact('karya'));
    }

    public function validationForm($id)
    {
        $karya = Karya::with(['user'])->findOrFail($id);
        return view('admin.karya.show', compact('karya'));
    }

    public function update(UpdateKaryaRequest $request, string $id)
    {
        $karya = Karya::findOrFail($id);

        $validated = $request->validated();

        if ($request->hasFile('preview_karya')) {
            if ($karya->preview_karya) {
                Storage::disk('public')->delete($karya->preview_karya);
            }
            $validated['preview_karya'] = $this->compressAndStoreImage($request->file('preview_karya'), 'karya');
        }

        if ($request->hasFile('file_karya')) {
            if ($karya->file_karya) {
                Storage::disk('public')->delete($karya->file_karya);
            }
            $validated['file_karya'] = $request->file('file_karya')->store('karya_files', 'public');
        }

        $karya->update($validated);

        return redirect()->route('karya.index')->with('success', 'Karya berhasil diupdate!');
    }

    // Admin - hapus karya
    public function destroy(string $id)
    {
        $karya = Karya::findOrFail($id);

        // File tidak dihapus secara fisik karena menggunakan SoftDeletes
        // Jika butuh hard delete, bisa diimplementasikan di method forceDelete()

        $karya->delete();

        return redirect()->route('karya.index')->with('success', 'Karya berhasil dihapus!');
    }

    // Admin - approve karya
    public function approve($id)
    {
        $karya = Karya::findOrFail($id);
        $karya->update(['status_validasi' => 'accepted']);

        \Modules\Core\Models\ActivityLog::create([
            'type' => 'Validation',
            'action' => 'Karya Diterima',
            'judul_karya' => $karya->judul,
            'deskripsi' => 'Karya ' . $karya->judul . ' telah divalidasi dan diterima.',
            'pembuat' => $karya->tim_pembuat ?? 'Mahasiswa',
            'validasi' => \Illuminate\Support\Facades\Auth::user()->name ?? 'Admin',
            'status' => 'validated',
            'link' => route('karyadetail', $karya->id)
        ]);

        try {
            if ($karya->user && $karya->user->email) {
                \Illuminate\Support\Facades\Mail::to($karya->user->email)->send(new \App\Mail\KaryaStatusMail($karya));
            }
        } catch (\Exception $e) {
            // Silently catch mail errors so it doesn't break flow if SMTP is not configured
        }

        try {
            if ($karya->user) {
                $karya->user->notify(new \Modules\Karya\Notifications\KaryaStatusNotification($karya));
            }
        } catch (\Exception $e) {
            // Silently catch notification/broadcast errors
        }

        return redirect()->route('karya.index')
            ->with('success', 'Karya berhasil disetujui!');
    }

    // Admin - reject karya
    public function reject($id)
    {
        $karya = Karya::findOrFail($id);
        $karya->update(['status_validasi' => 'rejected']);

        \Modules\Core\Models\ActivityLog::create([
            'type' => 'Validation',
            'action' => 'Karya Ditolak',
            'judul_karya' => $karya->judul,
            'deskripsi' => 'Karya ' . $karya->judul . ' telah ditolak.',
            'pembuat' => $karya->tim_pembuat ?? 'Mahasiswa',
            'validasi' => \Illuminate\Support\Facades\Auth::user()->name ?? 'Admin',
            'status' => 'rejected',
            'link' => '#'
        ]);

        try {
            if ($karya->user && $karya->user->email) {
                \Illuminate\Support\Facades\Mail::to($karya->user->email)->send(new \App\Mail\KaryaStatusMail($karya));
            }
        } catch (\Exception $e) {
            // Silently catch mail errors
        }

        try {
            if ($karya->user) {
                $karya->user->notify(new \Modules\Karya\Notifications\KaryaStatusNotification($karya));
            }
        } catch (\Exception $e) {
            // Silently catch notification/broadcast errors
        }

        return redirect()->route('karya.index')
            ->with('success', 'Karya berhasil ditolak!');
    }

    // Admin - halaman ajuan karya
    public function ajuanKarya()
    {
        $karyas = Karya::where('status_validasi', 'submission')->get();
        return view('admin.karya.ajuankarya', compact('karyas'));
    }

    // Admin - halaman lihat karya accepted
    public function lihatKarya()
    {
        $karyas = Karya::where('status_validasi', 'accepted')->orderBy('created_at', 'desc')->get();        
        $trashed = collect();
        return view('admin.karya.lihatkarya', compact('karyas', 'trashed'));
    }

    // Admin - export data ke Excel (.xlsx) dengan template premium
    public function exportExcel()
    {
        $karyas = Karya::with('user')
            ->whereIn('status_validasi', ['accepted', 'rejected'])
            ->orderBy('created_at', 'desc')
            ->get();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Laporan Karya');

        // ========== HEADER / TITLE SECTION ==========
        $sheet->mergeCells('A1:H1');
        $sheet->setCellValue('A1', 'LAPORAN DATA KARYA MAHASISWA');
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 16, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '4F46E5']],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, 'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER],
        ]);
        $sheet->getRowDimension(1)->setRowHeight(40);

        $sheet->mergeCells('A2:H2');
        $sheet->setCellValue('A2', 'Portal Karya Teknologi Rekayasa Perangkat Lunak — Sekolah Vokasi IPB University');
        $sheet->getStyle('A2')->applyFromArray([
            'font' => ['italic' => true, 'size' => 10, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '6366F1']],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ]);
        $sheet->getRowDimension(2)->setRowHeight(25);

        $sheet->mergeCells('A3:H3');
        $sheet->setCellValue('A3', 'Diekspor pada: ' . now()->format('d F Y, H:i:s') . ' WIB');
        $sheet->getStyle('A3')->applyFromArray([
            'font' => ['size' => 9, 'color' => ['rgb' => '6B7280']],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
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
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '1F2937']],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, 'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER],
            'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['rgb' => '374151']]],
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
                'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => $bgColor]],
                'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['rgb' => 'E5E7EB']]],
                'alignment' => ['vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER],
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
                'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
            ]);

            $sheet->getRowDimension($row)->setRowHeight(22);
            $row++;
            $no++;
        }

        // ========== FOOTER ==========
        $footerRow = $row + 1;
        $sheet->mergeCells("A{$footerRow}:H{$footerRow}");
        $sheet->setCellValue("A{$footerRow}", "Total: {$karyas->count()} karya | © " . date('Y') . " Portal TPL SV IPB");
        $sheet->getStyle("A{$footerRow}")->applyFromArray([
            'font' => ['italic' => true, 'size' => 9, 'color' => ['rgb' => '9CA3AF']],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ]);

        // ========== AUTO-SIZE COLUMNS ==========
        $widths = [6, 35, 8, 25, 15, 14, 20, 18];
        foreach ($colLetters as $i => $letter) {
            $sheet->getColumnDimension($letter)->setWidth($widths[$i]);
        }

        // ========== DOWNLOAD ==========
        $filename = "laporan_karya_" . date('Y-m-d_H-i-s') . ".xlsx";
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

        return response()->streamDownload(function() use ($writer) {
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    // Admin - halaman validasi konten
    public function validation()
    {
        $karyas = Karya::with('user')
            ->where('status_validasi', 'submission')
            ->latest()
            ->get();

        return view('admin.karya.validation.index', compact('karyas'));
    }

    // Admin - store karya baru (dari dashboard)
    public function storeAdmin(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string',
            'deskripsi' => 'required|string',
            'tim_pembuat' => 'required|string|max:255',
            'tahun' => 'required|integer|min:2000|max:' . (date('Y') + 1),
            'link_pengumpulan' => 'nullable|url',
            'preview_karya' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'file_karya' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        // Upload gambar jika ada
        $gambarPath = null;
        if ($request->hasFile('preview_karya')) {
            $gambarPath = $this->compressAndStoreImage($request->file('preview_karya'), 'karya');
        }

        // Upload PDF jika ada
        $filePath = null;
        if ($request->hasFile('file_karya')) {
            $filePath = $request->file('file_karya')->store('karya_files', 'public');
        }

        // Simpan ke database dengan status submission
        Karya::create([
            'user_id' => Auth::id(),
            'judul' => $validated['judul'],
            'kategori' => $validated['kategori'],
            'deskripsi' => $validated['deskripsi'],
            'tim_pembuat' => $validated['tim_pembuat'],
            'tahun' => $validated['tahun'],
            'link_pengumpulan' => $validated['link_pengumpulan'] ?? null,
            'preview_karya' => $gambarPath,
            'file_karya' => $filePath,
            'status_validasi' => 'submission',
            'tanggal_upload' => now(),
        ]);

        return redirect()->route('validasikonten')
            ->with('success', 'Karya berhasil ditambahkan! Silakan validasi.');
    }

    // Admin - memulihkan karya terhapus
    public function restore($id)
    {
        $karya = Karya::onlyTrashed()->findOrFail($id);
        $karya->restore();

        return redirect()->route('karya.index')->with('success', 'Karya berhasil dipulihkan!');
    }

    public function forceDelete($id)
    {
        $karya = Karya::onlyTrashed()->findOrFail($id);
        if ($karya->preview_karya) {
            Storage::disk('public')->delete($karya->preview_karya);
        }
        if ($karya->file_karya) {
            Storage::disk('public')->delete($karya->file_karya);
        }
        $karya->forceDelete();

        return redirect()->route('karya.index')->with('success', 'Karya berhasil dihapus secara permanen!');
    }

    private function compressAndStoreImage($uploadedFile, $folder, $quality = 75)
    {
        $extension = $uploadedFile->getClientOriginalExtension();
        $fileName = time() . '_' . Str::random(10) . '.' . $extension;
        $tempPath = $uploadedFile->getRealPath();
        
        $destinationFolder = 'public/' . $folder;
        if (!Storage::exists($destinationFolder)) {
            Storage::makeDirectory($destinationFolder);
        }
        
        $destinationPath = storage_path('app/' . $destinationFolder . '/' . $fileName);
        
        try {
            $info = getimagesize($tempPath);
            $mime = $info['mime'] ?? '';
            
            if ($mime === 'image/jpeg' || $mime === 'image/jpg') {
                $image = imagecreatefromjpeg($tempPath);
                if ($image) {
                    imagejpeg($image, $destinationPath, $quality);
                    imagedestroy($image);
                    return $folder . '/' . $fileName;
                }
            } elseif ($mime === 'image/png') {
                $image = imagecreatefrompng($tempPath);
                if ($image) {
                    imagealphablending($image, false);
                    imagesavealpha($image, true);
                    $pngQuality = 9 - round(($quality / 100) * 9);
                    imagepng($image, $destinationPath, $pngQuality);
                    imagedestroy($image);
                    return $folder . '/' . $fileName;
                }
            }
        } catch (\Exception $e) {
            // Fallback if compression fails
        }
        
        return $uploadedFile->store($folder, 'public');
    }
}
