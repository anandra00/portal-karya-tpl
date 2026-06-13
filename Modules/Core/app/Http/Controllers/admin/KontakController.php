<?php

namespace Modules\Core\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Modules\Core\Models\PesanKontak;
use Illuminate\Http\Request;

class KontakController extends Controller
{
    public function index()
    {
        $pesans = PesanKontak::orderBy('tanggal_kirim', 'desc')->paginate(20);
        return view('admin.kontak.index', compact('pesans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pengirim' => 'required|string|max:50',
            'email_pengirim' => 'required|email|max:50',
            'isi_pesan' => 'required|string|max:1000',
        ]);

        $validated['status'] = 'belum_dibaca';
        $validated['tanggal_kirim'] = now();

        PesanKontak::create($validated);

        return back()->with('success', 'Pesan berhasil dikirim!');
    }

    public function show(string $id)
    {
        $pesan = PesanKontak::findOrFail($id);

        if ($pesan->status == 'belum_dibaca') {
            $pesan->update(['status' => 'dibaca']);
        }

        return view('admin.kontak.show', compact('pesan'));
    }

    public function updateStatus(Request $request, string $id)
    {
        $pesan = PesanKontak::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:belum_dibaca,dibaca,dibalas',
        ]);

        $pesan->update($validated);

        return back()->with('success', 'Status pesan berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $pesan = PesanKontak::findOrFail($id);
        $pesan->delete();

        return redirect()->route('admin.kontak.index')->with('success', 'Pesan berhasil dihapus!');
    }
}
