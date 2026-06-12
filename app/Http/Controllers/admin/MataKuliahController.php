<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MataKuliah;
use Illuminate\Http\Request;

class MataKuliahController extends Controller
{
    // Tampilkan semua data (untuk admin)
    public function index()
    {
        $matakuliahs = MataKuliah::orderBy('semester')->orderBy('kode_matkul')->get();
        return view('admin.matakuliah.index', compact('matakuliahs'));
    }

    // Form tambah data
    public function create()
    {
        return view('admin.matakuliah.create');
    }

    // Simpan data baru
    public function store(Request $request)
    {
        $request->validate([
            'kode_matkul' => 'required|unique:mata_kuliahs',
            'nama_matkul' => 'required',
            'sks_teori' => 'required',
            'sks_praktik' => 'required',
            'semester' => 'required|integer|min:1|max:8'
        ]);

        MataKuliah::create($request->all());

        \Illuminate\Support\Facades\Cache::forget('mata_kuliah_user');

        return redirect()->route('admin.matakuliah.index')
            ->with('success', 'Mata kuliah berhasil ditambahkan!');
    }

    // Form edit data
    public function edit($id)
    {
        $matakuliah = MataKuliah::findOrFail($id);
        return view('admin.matakuliah.edit', compact('matakuliah'));
    }

    // Update data
    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_matkul' => 'required|unique:mata_kuliahs,kode_matkul,'.$id,
            'nama_matkul' => 'required',
            'sks_teori' => 'required',
            'sks_praktik' => 'required',
            'semester' => 'required|integer|min:1|max:8'
        ]);

        $matakuliah = MataKuliah::findOrFail($id);
        $matakuliah->update($request->all());

        \Illuminate\Support\Facades\Cache::forget('mata_kuliah_user');

        return redirect()->route('admin.matakuliah.index')
            ->with('success', 'Mata kuliah berhasil diupdate!');
    }

    // Hapus data
    public function destroy($id)
    {
        $matakuliah = MataKuliah::findOrFail($id);
        $matakuliah->delete();

        \Illuminate\Support\Facades\Cache::forget('mata_kuliah_user');

        return redirect()->route('admin.matakuliah.index')
            ->with('success', 'Mata kuliah berhasil dihapus!');
    }

    public function indexUser()
    {
        // Ambil data dari database dan cache selama 1 jam
        $data = \Illuminate\Support\Facades\Cache::remember('mata_kuliah_user', 3600, function () {
            return [
                'semester1' => MataKuliah::where('semester', 1)->get(),
                'semester2' => MataKuliah::where('semester', 2)->get(),
                'semester3' => MataKuliah::where('semester', 3)->get(),
                'semester4' => MataKuliah::where('semester', 4)->get(),
                'semester5' => MataKuliah::where('semester', 5)->get(),
                'semester6' => MataKuliah::where('semester', 6)->get(),
                'semester7' => MataKuliah::where('semester', 7)->get(),
                'semester8' => MataKuliah::where('semester', 8)->get(),
            ];
        });

        return view('pages.matkul', $data);
    }
}