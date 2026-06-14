<?php

namespace Modules\Core\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Karya\Models\Karya;
use Modules\Akademik\Models\Dosen;

class ApiController extends Controller
{
    /**
     * Get list of all accepted works (Karya).
     */
    public function getKaryas(Request $request)
    {
        $karyas = Karya::where('status_validasi', 'accepted')
            ->with(['user:id,name'])
            ->orderBy('created_at', 'desc')
            ->get();

        $formatted = $karyas->map(function ($karya) {
            return [
                'id' => $karya->id,
                'judul' => $karya->judul,
                'deskripsi' => $karya->deskripsi,
                'kategori' => $karya->kategori,
                'tahun' => $karya->tahun,
                'file_karya' => $karya->file_karya,
                'preview_karya' => $karya->preview_karya,
                'link_pengumpulan' => $karya->link_pengumpulan,
                'tim_pembuat' => $karya->tim_pembuat,
                'tanggal_upload' => $karya->tanggal_upload,
                'created_at' => $karya->created_at,
                'uploader' => $karya->user ? [
                    'id' => $karya->user->id,
                    'name' => $karya->user->name,
                ] : null,
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'List of accepted works retrieved successfully',
            'data' => $formatted
        ], 200);
    }

    /**
     * Get detail of a specific accepted work.
     */
    public function getKaryaDetail($id)
    {
        $karya = Karya::where('status_validasi', 'accepted')
            ->with(['user:id,name', 'reviews.user:id,name'])
            ->find($id);

        if (!$karya) {
            return response()->json([
                'success' => false,
                'message' => 'Karya not found or not accepted'
            ], 404);
        }

        $formatted = [
            'id' => $karya->id,
            'judul' => $karya->judul,
            'deskripsi' => $karya->deskripsi,
            'kategori' => $karya->kategori,
            'tahun' => $karya->tahun,
            'file_karya' => $karya->file_karya,
            'preview_karya' => $karya->preview_karya,
            'link_pengumpulan' => $karya->link_pengumpulan,
            'tim_pembuat' => $karya->tim_pembuat,
            'tanggal_upload' => $karya->tanggal_upload,
            'created_at' => $karya->created_at,
            'uploader' => $karya->user ? [
                'id' => $karya->user->id,
                'name' => $karya->user->name,
            ] : null,
            'reviews' => $karya->reviews->map(function ($review) {
                return [
                    'id' => $review->id,
                    'rating' => $review->rating,
                    'comment' => $review->comment,
                    'created_at' => $review->created_at,
                    'user' => $review->user ? [
                        'id' => $review->user->id,
                        'name' => $review->user->name,
                    ] : null,
                ];
            })
        ];

        return response()->json([
            'success' => true,
            'message' => 'Karya detail retrieved successfully',
            'data' => $formatted
        ], 200);
    }

    /**
     * Get list of all lecturers (Dosen).
     */
    public function getDosens()
    {
        $dosens = Dosen::orderBy('nama', 'asc')->get();

        $formatted = $dosens->map(function ($dosen) {
            return [
                'id' => $dosen->id,
                'nama' => $dosen->nama,
                'research_interest' => $dosen->research_interest,
                'prodi' => $dosen->prodi,
                'foto' => $dosen->foto,
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'List of lecturers retrieved successfully',
            'data' => $formatted
        ], 200);
    }
}
