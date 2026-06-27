<?php

namespace Modules\Core\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Karya\Models\Karya;
use Modules\Akademik\Models\Dosen;
use OpenApi\Attributes as OA;

#[OA\Info(
    title: "Portal Karya TRPL SV IPB REST API",
    version: "1.0.0",
    description: "Dokumentasi REST API v1 untuk Portal Karya Mahasiswa TRPL Sekolah Vokasi IPB University."
)]
#[OA\Server(
    url: "/api",
    description: "Server API Utama (Local/Production)"
)]
#[OA\SecurityScheme(
    securityScheme: "bearerAuth",
    type: "http",
    scheme: "bearer",
    bearerFormat: "JWT",
    description: "Gunakan Token Bearer yang diperoleh setelah memanggil API login."
)]
class ApiController extends Controller
{
    #[OA\Get(
        path: "/v1/karyas",
        summary: "Dapatkan semua karya mahasiswa yang berstatus accepted",
        tags: ["Karya"]
    )]
    #[OA\Response(
        response: 200,
        description: "Daftar karya mahasiswa berhasil diambil.",
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: "success", type: "boolean", example: true),
                new OA\Property(property: "message", type: "string", example: "List of accepted works retrieved successfully"),
                new OA\Property(property: "data", type: "array", items: new OA\Items(type: "object"))
            ]
        )
    )]
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

    #[OA\Get(
        path: "/v1/karyas/{id}",
        summary: "Dapatkan detail satu karya mahasiswa beserta ulasannya",
        tags: ["Karya"]
    )]
    #[OA\Parameter(
        name: "id",
        in: "path",
        description: "ID Karya",
        required: true,
        schema: new OA\Schema(type: "integer")
    )]
    #[OA\Response(
        response: 200,
        description: "Detail karya berhasil diambil.",
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: "success", type: "boolean", example: true),
                new OA\Property(property: "message", type: "string", example: "Karya detail retrieved successfully"),
                new OA\Property(property: "data", type: "object")
            ]
        )
    )]
    #[OA\Response(
        response: 404,
        description: "Karya tidak ditemukan atau belum diterima."
    )]
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

    #[OA\Get(
        path: "/v1/dosens",
        summary: "Dapatkan daftar dosen prodi",
        tags: ["Dosen"]
    )]
    #[OA\Response(
        response: 200,
        description: "Daftar dosen berhasil diambil.",
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: "success", type: "boolean", example: true),
                new OA\Property(property: "message", type: "string", example: "List of lecturers retrieved successfully"),
                new OA\Property(property: "data", type: "array", items: new OA\Items(type: "object"))
            ]
        )
    )]
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

    #[OA\Post(
        path: "/v1/login",
        summary: "Otentikasi pengguna & dapatkan Token API",
        tags: ["Auth"]
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ["email", "password"],
            properties: [
                new OA\Property(property: "email", type: "string", format: "email", example: "mahasiswa@apps.ipb.ac.id"),
                new OA\Property(property: "password", type: "string", format: "password", example: "password123")
            ]
        )
    )]
    #[OA\Response(
        response: 200,
        description: "Login sukses, mengembalikan token.",
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: "success", type: "boolean", example: true),
                new OA\Property(property: "message", type: "string", example: "Login berhasil"),
                new OA\Property(property: "token", type: "string", example: "1|AbCdEfGhIjKlMnOpQrStUvWxYz"),
                new OA\Property(property: "user", type: "object")
            ]
        )
    )]
    #[OA\Response(
        response: 401,
        description: "Kredensial tidak valid."
    )]
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = \App\Models\User::where('email', $request->email)->first();

        if (!$user || !\Illuminate\Support\Facades\Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Kredensial tidak valid'
            ], 401);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil',
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
            ]
        ], 200);
    }

    #[OA\Post(
        path: "/v1/karyas",
        summary: "Unggah karya baru (Butuh Token)",
        tags: ["Karya"],
        security: [["bearerAuth" => []]]
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ["judul", "kategori", "deskripsi", "tim_pembuat", "tahun"],
            properties: [
                new OA\Property(property: "judul", type: "string", example: "E-Learning TRPL"),
                new OA\Property(property: "kategori", type: "string", example: "Web Application"),
                new OA\Property(property: "deskripsi", type: "string", example: "Aplikasi pembelajaran interaktif"),
                new OA\Property(property: "tim_pembuat", type: "string", example: "Budi, Susi"),
                new OA\Property(property: "tahun", type: "integer", example: 2026),
                new OA\Property(property: "link", type: "string", format: "url", example: "https://github.com/example/elearning")
            ]
        )
    )]
    #[OA\Response(
        response: 201,
        description: "Karya berhasil diajukan.",
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: "success", type: "boolean", example: true),
                new OA\Property(property: "message", type: "string", example: "Karya berhasil diajukan! Menunggu validasi admin."),
                new OA\Property(property: "data", type: "object")
            ]
        )
    )]
    #[OA\Response(
        response: 401,
        description: "Unauthorized (Token salah atau hilang)."
    )]
    #[OA\Response(
        response: 403,
        description: "Hanya mahasiswa IPB yang diizinkan mengunggah karya."
    )]
    public function storeKarya(Request $request)
    {
        $user = auth()->user();

        // Rules specific for mahasiswa (email must end with apps.ipb.ac.id)
        if ($user->role === 'user' && !str_ends_with($user->email, '@apps.ipb.ac.id')) {
            return response()->json([
                'success' => false,
                'message' => 'Hanya mahasiswa IPB yang diizinkan mengunggah karya.'
            ], 403);
        }

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string',
            'deskripsi' => 'required|string',
            'tim_pembuat' => 'required|string|max:255',
            'tahun' => 'required|integer|min:2000|max:' . (date('Y') + 1),
            'link' => 'nullable|url',
        ]);

        $karya = Karya::create([
            'user_id' => $user->id,
            'judul' => $validated['judul'],
            'kategori' => $validated['kategori'],
            'deskripsi' => $validated['deskripsi'],
            'tim_pembuat' => $validated['tim_pembuat'],
            'tahun' => $validated['tahun'],
            'link_pengumpulan' => $validated['link'] ?? null,
            'status_validasi' => 'submission',
            'tanggal_upload' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Karya berhasil diajukan! Menunggu validasi admin.',
            'data' => $karya
        ], 201);
    }

    #[OA\Post(
        path: "/v1/karyas/{id}/reviews",
        summary: "Berikan ulasan dan rating pada karya (Butuh Token)",
        tags: ["Review"],
        security: [["bearerAuth" => []]]
    )]
    #[OA\Parameter(
        name: "id",
        in: "path",
        description: "ID Karya yang ingin diulas",
        required: true,
        schema: new OA\Schema(type: "integer")
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ["rating"],
            properties: [
                new OA\Property(property: "rating", type: "integer", minimum: 1, maximum: 5, example: 5),
                new OA\Property(property: "comment", type: "string", example: "Sangat inovatif!")
            ]
        )
    )]
    #[OA\Response(
        response: 201,
        description: "Ulasan berhasil ditambahkan.",
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: "success", type: "boolean", example: true),
                new OA\Property(property: "message", type: "string", example: "Review berhasil ditambahkan!"),
                new OA\Property(property: "data", type: "object")
            ]
        )
    )]
    #[OA\Response(
        response: 400,
        description: "Anda sudah memberikan review untuk karya ini."
    )]
    #[OA\Response(
        response: 401,
        description: "Unauthorized (Token salah atau hilang)."
    )]
    public function storeReview(Request $request, $id)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $karya = Karya::findOrFail($id);

        $existingReview = \Modules\Karya\Models\Review::where('karya_id', $karya->id)
            ->where('user_id', auth()->id())
            ->first();

        if ($existingReview) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah memberikan review untuk karya ini.'
            ], 400);
        }

        $review = \Modules\Karya\Models\Review::create([
            'karya_id' => $karya->id,
            'user_id' => auth()->id(),
            'rating' => $validated['rating'],
            'comment' => $validated['comment'] ?? null,
        ]);

        // Trigger Notification
        try {
            if ($karya->user && $karya->user->id !== auth()->id()) {
                $karya->user->notify(new \Modules\Karya\Notifications\NewReviewNotification($review));
            }
        } catch (\Exception $e) {
            // Silently catch broadcast errors
        }

        return response()->json([
            'success' => true,
            'message' => 'Review berhasil ditambahkan!',
            'data' => $review
        ], 201);
    }
}
