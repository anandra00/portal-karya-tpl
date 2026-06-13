<?php

namespace Modules\Core\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Modules\Core\Models\ProfilProdi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfilProdiController extends Controller
{
    public function index()
    {
        $profil = ProfilProdi::first();
        return view('admin.info-prodi.index', compact('profil'));
    }

    public function edit(string $type)
    {
        $profil = ProfilProdi::first();
        return view('admin.info-prodi.edit', compact('profil', 'type'));
    }

    public function editWithType($kodeProdi, $type)
    {
        $profil = ProfilProdi::where('kode_prodi', $kodeProdi)->first();

        if (!$profil) {
            abort(404, 'Data tidak ditemukan');
        }
        return view('admin.info-prodi.edit', [
            'profil' => $profil,
            'type' => $type,
        ]);
    }


    public function update(Request $request, $kodeProdi)
    {
        $validated = $request->validate([
            'visi'      => 'nullable|string',
            'misi'      => 'nullable|string',
            'capaian'   => 'nullable|string',
            'video'     => 'nullable|file',
        ]);

        // Ambil profil berdasarkan kode_prodi
        $profil = ProfilProdi::where('kode_prodi', $kodeProdi)->first();

        if (!$profil) {
            return back()->with('error', 'Data profil tidak ditemukan.');
        }

        // Handle upload video
        if ($request->hasFile('video')) {

            // Hapus video lama
            if ($profil->video && file_exists(public_path('uploads/video/' . $profil->video))) {
                unlink(public_path('uploads/video/' . $profil->video));
            }

            // Simpan video baru
            $videoName = time() . '_' . $request->video->getClientOriginalName();
            $request->video->move(public_path('uploads/video'), $videoName);

            $validated['video'] = $videoName;
        }

        // Update profil
        $profil->update($validated);

        \Illuminate\Support\Facades\Cache::forget('profil_prodi');

        return redirect()->route('info-prodi.index')
                        ->with('success', 'Profil prodi berhasil diperbarui!');
    }   
    // HALAMAN USER
    public function showUser()
    {
        $profil = \Illuminate\Support\Facades\Cache::remember('profil_prodi', 3600, function () {
            return ProfilProdi::first();
        });
        return view('pages.tentang', compact('profil'));
    }
}
