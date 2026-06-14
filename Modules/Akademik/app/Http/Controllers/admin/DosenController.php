<?php

namespace Modules\Akademik\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Modules\Akademik\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Modules\Akademik\Http\Requests\StoreDosenRequest;
use Modules\Akademik\Http\Requests\UpdateDosenRequest;

class DosenController extends Controller
{
    public function index()
    {
        // Perbaiki: variable jadi plural, column name jadi 'nama'
        $dosens = Dosen::orderBy('nama', 'asc')->get();
        return view('admin.dosen.index', compact('dosens'));
    }

    public function create()
    {
        return view('admin.dosen.create');
    }

    public function store(StoreDosenRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('foto')) {
            $validated['foto'] = $this->compressAndStoreImage($request->file('foto'), 'dosen');
        }

        Dosen::create($validated);

        return redirect()
            ->route('dosen.index')
            ->with('success', 'Data dosen berhasil ditambahkan!');
    }

    public function show(string $id)
    {
        $dosen = Dosen::findOrFail($id);
        // Perbaiki: konsisten pakai admin.pages
        return view('admin.dosen.show', compact('dosen'));
    }

    public function edit(string $id)
    {
        $dosen = Dosen::findOrFail($id);
        return view('admin.dosen.edit', compact('dosen'));
    }

    public function update(UpdateDosenRequest $request, string $id)
    {
        $dosen = Dosen::findOrFail($id);

        $validated = $request->validated();

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($dosen->foto) {
                Storage::disk('public')->delete($dosen->foto);
            }

            $validated['foto'] = $this->compressAndStoreImage($request->file('foto'), 'dosen');
        }

        $dosen->update($validated);

        return redirect()->route('dosen.index')
                        ->with('success', 'Data dosen berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $dosen = Dosen::findOrFail($id);

        // Hapus foto jika ada
        if ($dosen->foto) {
            Storage::disk('public')->delete($dosen->foto);
        }

        $dosen->delete();

        // Perbaiki: route name yang benar
        return redirect()->route('dosen.index')
                        ->with('success', 'Data dosen berhasil dihapus!');
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
