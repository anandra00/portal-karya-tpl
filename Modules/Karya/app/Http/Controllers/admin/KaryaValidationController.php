<?php

namespace Modules\Karya\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Modules\Karya\Models\Karya;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class KaryaValidationController extends Controller
{
    public function validation()
    {
        $karyas = Karya::with('user')
            ->where('status_validasi', 'submission')
            ->latest()
            ->get();

        return view('admin.karya.validation.index', compact('karyas'));
    }

    public function validationForm($id)
    {
        $karya = Karya::with(['user'])->findOrFail($id);
        return view('admin.karya.show', compact('karya'));
    }

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
            'validasi' => Auth::user()->name ?? 'Admin',
            'status' => 'validated',
            'link' => route('karya.public.show', $karya->id)
        ]);

        $this->sendNotifications($karya, 'accepted');

        return redirect()->route('karya.index')
            ->with('success', 'Karya berhasil disetujui!');
    }

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
            'validasi' => Auth::user()->name ?? 'Admin',
            'status' => 'rejected',
            'link' => '#'
        ]);

        $this->sendNotifications($karya, 'rejected');

        return redirect()->route('karya.index')
            ->with('success', 'Karya berhasil ditolak!');
    }

    public function storeAdmin(\Modules\Karya\Http\Requests\AdminStoreKaryaRequest $request)
    {
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

    private function sendNotifications($karya, string $status)
    {
        try {
            if ($karya->user && $karya->user->email) {
                \Illuminate\Support\Facades\Mail::to($karya->user->email)
                    ->send(new \App\Mail\KaryaStatusMail($karya));
            }
        } catch (\Exception $e) {
            Log::error('Failed to send Karya status email', [
                'karya_id' => $karya->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }

        try {
            if ($karya->user) {
                $karya->user->notify(new \Modules\Karya\Notifications\KaryaStatusNotification($karya));
            }
        } catch (\Exception $e) {
            Log::error('Failed to send Karya status notification', [
                'karya_id' => $karya->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    private function compressAndStoreImage($uploadedFile, $folder, $quality = 75)
    {
        $extension = $uploadedFile->getClientOriginalExtension();
        $fileName = time() . '_' . \Illuminate\Support\Str::random(10) . '.' . $extension;
        $tempPath = $uploadedFile->getRealPath();

        $destinationFolder = 'public/' . $folder;
        if (!\Illuminate\Support\Facades\Storage::exists($destinationFolder)) {
            \Illuminate\Support\Facades\Storage::makeDirectory($destinationFolder);
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
        }

        return $uploadedFile->store($folder, 'public');
    }
}