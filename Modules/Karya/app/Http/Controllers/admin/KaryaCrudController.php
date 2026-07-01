<?php

namespace Modules\Karya\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Modules\Karya\Models\Karya;
use Modules\Karya\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Modules\Karya\Http\Requests\StoreKaryaRequest;
use Modules\Karya\Http\Requests\UpdateKaryaRequest;

class KaryaCrudController extends Controller
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

        $karya = $karyas;
        $categories = Kategori::all();
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
    // UNTUK ADMIN (Backend CRUD)
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

    // Admin - form tambah karya
    public function create()
    {
        $categories = Kategori::all();
        return view('admin.karya.create', compact('categories'));
    }

    public function store(StoreKaryaRequest $request)
    {
        $role = Auth::user()->role;
        $validated = $request->validated();

        $gambarPath = null;
        if ($request->hasFile('preview_karya')) {
            $gambarPath = $this->compressAndStoreImage($request->file('preview_karya'), 'karya');
        }

        $filePath = null;
        if ($request->hasFile('file_karya')) {
            $filePath = $request->file('file_karya')->store('karya_files', 'public');
        }

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

        if ($role === 'admin') {
            return redirect()->route('karya.index')
                ->with('success', 'Karya berhasil ditambahkan!');
        }

        return redirect()->route('unggah')
            ->with('success', 'Karya berhasil diunggah! Menunggu validasi admin.');
    }

    // Admin - lihat detail karya
    public function show(string $id)
    {
        $karya = Karya::with(['user', 'reviews.user'])->findOrFail($id);
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
        $karya->delete();

        return redirect()->route('karya.index')->with('success', 'Karya berhasil dihapus!');
    }

    // Admin - memulihkan karya terhapus
    public function restore($id)
    {
        $karya = Karya::onlyTrashed()->findOrFail($id);
        $karya->restore();

        return redirect()->route('karya.index')->with('success', 'Karya berhasil dipulihkan!');
    }

    // Admin - force delete
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

    public function ajuanKarya()
    {
        $karyas = Karya::where('status_validasi', 'submission')->get();
        return view('admin.karya.ajuankarya', compact('karyas'));
    }

    public function lihatKarya()
    {
        $karyas = Karya::where('status_validasi', 'accepted')->orderBy('created_at', 'desc')->get();        
        $trashed = collect();
        return view('admin.karya.lihatkarya', compact('karyas', 'trashed'));
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
