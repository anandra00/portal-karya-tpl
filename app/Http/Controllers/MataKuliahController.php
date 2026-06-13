<?php

namespace App\Http\Controllers;

use Modules\Akademik\Models\MataKuliah;
use Illuminate\Http\Request;

class MataKuliahController extends Controller
{
    public function index()
    {
        // Ambil data dari database, dikelompokkan per semester
        $semester1 = MataKuliah::where('semester', 1)->get();
        $semester2 = MataKuliah::where('semester', 2)->get();
        $semester3 = MataKuliah::where('semester', 3)->get();
        $semester4 = MataKuliah::where('semester', 4)->get();
        $semester5 = MataKuliah::where('semester', 5)->get();
        $semester6 = MataKuliah::where('semester', 6)->get();
        $semester7 = MataKuliah::where('semester', 7)->get();
        $semester8 = MataKuliah::where('semester', 8)->get();

        return view('matakuliah', compact(
            'semester1', 'semester2', 'semester3', 'semester4',
            'semester5', 'semester6', 'semester7', 'semester8'
        ));
    }
}
