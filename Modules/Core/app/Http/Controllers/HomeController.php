<?php

namespace Modules\Core\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Akademik\Models\Berita;
use Modules\Karya\Models\Karya;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil 3 karya terbaru yang ACCEPTED dengan relasi reviews dan reviews.user (menghindari N+1)
        $karyas = Karya::where('status_validasi', 'accepted')
                      ->with(['reviews.user'])
                      ->orderBy('created_at', 'desc')
                      ->limit(3)
                      ->get();
        
        $beritas = Berita::latest()->get();
        $karyas_count = Karya::where('status_validasi', 'accepted')->count();
        $dosens_count = \Modules\Akademik\Models\Dosen::count();
        $reviews_count = \Modules\Karya\Models\Review::count();
        $matkuls_count = \Modules\Akademik\Models\MataKuliah::count();
        
        return view('pages.homepages', compact('karyas', 'beritas', 'karyas_count', 'dosens_count', 'reviews_count', 'matkuls_count'));
    }

    public function dosen()
    {
        $dosens = \Illuminate\Support\Facades\Cache::remember('dosen_all', 3600, function () {
            return \Modules\Akademik\Models\Dosen::all();
        });
        return view('pages.dosen', compact('dosens'));
    }

    public function faq()
    {
        return view('pages.faq');
    }

    public function readAllNotifications()
    {
        if (auth()->check()) {
            auth()->user()->unreadNotifications->markAsRead();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 401);
    }
}
