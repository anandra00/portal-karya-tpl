<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Karya;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

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

        // Filter berdasarkan search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
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
        return view('pages.karya', compact('karya'));
    }

    // Detail karya
    public function userShow(string $id)
    {
        $karya = Karya::with('reviews.user')->findOrFail($id);
        $review = \App\Models\Review::with('user')->where('karya_id', $id)->get();

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
        $accepted = Karya::with('user')
            ->where('status_validasi', 'accepted')
            ->get();

        $rejected = Karya::with('user')
            ->where('status_validasi', 'rejected')
            ->get();

        return view('admin.karya.index', compact('accepted', 'rejected'));
    }

    public function store(Request $request)
    {
        // ambil role user
        $role = Auth::user()->role;

        // ============================================
        // VALIDASI BERBEDA UNTUK USER DAN ADMIN
        // ============================================

        // Jika user biasa → wajib email @apps.ipb.ac.id
        if ($role === 'user') {
            $validated = $request->validate([
                'judul' => 'required|string|max:255',
                'kategori' => 'required|string',
                'deskripsi' => 'required|string',
                'tim_pembuat' => 'required|string|max:255',
                'email' => ['required', 'email', 'regex:/^[a-zA-Z0-9._%+-]+@apps\.ipb\.ac\.id$/'],
                'preview_karya' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'tahun' => 'required|integer|min:2000|max:' . (date('Y') + 1),
                'link' => 'required|url',
            ], [
                'email.regex' => 'Email wajib menggunakan domain @apps.ipb.ac.id',
                'preview_karya.required' => 'Gambar wajib diupload',
            ]);
        }

        // Jika admin atau superadmin → TIDAK pakai email validasi
        else {
            $validated = $request->validate([
                'judul' => 'required|string|max:255',
                'kategori' => 'required|string',
                'deskripsi' => 'required|string',
                'tim_pembuat' => 'required|string|max:255',
                'preview_karya' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'tahun' => 'required|integer|min:2000|max:' . (date('Y') + 1),
                'link' => 'nullable|url',
            ]);
        }

        // 2. Upload gambar
        $gambarPath = null;
        if ($request->hasFile('preview_karya')) {
            $gambarPath = $request->file('preview_karya')->store('karya', 'public');
        }

        // 3. Simpan ke database
        Karya::create([
            'user_id' => Auth::id(),
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'],
            'kategori' => $validated['kategori'],
            'tahun' => $validated['tahun'],
            'preview_karya' => $gambarPath,
            'tim_pembuat' => $validated['tim_pembuat'],
            'link_pengumpulan' => $validated['link'],
            'status_validasi' => 'submission',
            'tanggal_upload' => now(),
        ]);

        // 4. Redirect dengan pesan sukses
        return redirect()->route('karya.validasi')
            ->with('success', 'Karya berhasil diunggah! Menunggu validasi admin.');
    }

    // Admin - form tambah karya
    public function create()
    {
        return view('admin.karya.create');
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
        return view('admin.karya.validation.show', compact('karya'));
    }

    // Admin - update karya
    public function update(Request $request, string $id)
    {
        $karya = Karya::findOrFail($id);

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tahun' => 'required|integer|min:2000|max:' . (date('Y') + 1),
            'tim_pembuat' => 'required|string',
            'preview_karya' => 'nullable|string',
            'status_validasi' => 'required',
        ]);

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

        \App\Models\ActivityLog::create([
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

        return redirect()->route('kelolakarya')
            ->with('success', 'Karya berhasil disetujui!');
    }

    // Admin - reject karya
    public function reject($id)
    {
        $karya = Karya::findOrFail($id);
        $karya->update(['status_validasi' => 'rejected']);

        \App\Models\ActivityLog::create([
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

        return redirect()->route('kelolakarya')
            ->with('success', 'Karya berhasil ditolak!');
    }

    // Admin - export data ke CSV
    public function exportCsv()
    {
        $karyas = Karya::with('user')->get();

        $filename = "laporan_karya_" . date('Y-m-d_H-i-s') . ".csv";

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['ID', 'Judul Karya', 'Tahun', 'Tim Pembuat', 'Kategori', 'Status', 'Pengunggah', 'Tanggal Upload'];

        $callback = function() use($karyas, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($karyas as $karya) {
                $row['ID']  = $karya->id;
                $row['Judul Karya']    = $karya->judul;
                $row['Tahun']    = $karya->tahun;
                $row['Tim Pembuat']  = $karya->tim_pembuat;
                $row['Kategori']  = $karya->kategori->nama ?? '-';
                $row['Status']  = $karya->status_validasi;
                $row['Pengunggah']  = $karya->user->name ?? 'Unknown';
                $row['Tanggal Upload']  = $karya->created_at->format('Y-m-d H:i:s');

                fputcsv($file, array($row['ID'], $row['Judul Karya'], $row['Tahun'], $row['Tim Pembuat'], $row['Kategori'], $row['Status'], $row['Pengunggah'], $row['Tanggal Upload']));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
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

    // dan dibawah ini tambahan terbaru ya 
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
        ]);

        // Upload gambar jika ada
        $gambarPath = null;
        if ($request->hasFile('preview_karya')) {
            $gambarPath = $request->file('preview_karya')->store('karya', 'public');
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
            'status_validasi' => 'submission',
            'tanggal_upload' => now(),
        ]);

        return redirect()->route('validasikonten')
            ->with('success', 'Karya berhasil ditambahkan! Silakan validasi.');
    }
}