<?php

namespace Modules\Akademik\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Modules\Akademik\Models\MataKuliah;
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
            $matkul = MataKuliah::all()->groupBy('semester');
            
            return [
                'semester1' => $matkul->get(1, collect()),
                'semester2' => $matkul->get(2, collect()),
                'semester3' => $matkul->get(3, collect()),
                'semester4' => $matkul->get(4, collect()),
                'semester5' => $matkul->get(5, collect()),
                'semester6' => $matkul->get(6, collect()),
                'semester7' => $matkul->get(7, collect()),
                'semester8' => $matkul->get(8, collect()),
            ];
        });

        return view('pages.matkul', $data);
    }
}
