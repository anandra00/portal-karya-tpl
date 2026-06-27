<?php

namespace Modules\Akademik\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Akademik\Models\Berita;

class BeritaUserController extends Controller
{
    public function index()
    {
        $berita = Berita::latest()->get();
        return view('pages.berita_list', compact('berita'));
    }

    public function show($id)
    {
        $berita = Berita::findOrFail($id);
        return view('pages.berita', compact('berita'));
    }
}
