# 🧠 OpenAPI & Swagger API Documentation

API RESTful v1 pada **Portal Karya TRPL** didokumentasikan secara interaktif menggunakan package `darkaonline/l5-swagger`.

---

## 1. Akses Dokumentasi

Dokumentasi API interaktif dapat diakses melalui browser pada URL berikut:
- **Swagger UI**: `/api/documentation`
- **Raw JSON Schema**: `/docs` (misalnya `/storage/api-docs/api-docs.json`)

*Catatan: Mulai QA audit terakhir, Swagger UI telah dilindungi oleh middleware hak akses sehingga hanya admin/superadmin yang masuk log yang dapat mengaksesnya.*

---

## 2. Struktur PHP 8 Attributes (OpenAPI 3.0 Specs)

Dokumentasi ini ditulis langsung di atas kode Controller menggunakan anotasi **PHP 8 Attributes** (`OpenApi\Attributes` alias `OA`).

### Contoh Pendefinisian Skema Info Global:
```php
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
    bearerFormat: "JWT"
)]
```

### Contoh Pendefinisian Endpoint Endpoint (`GET`):
```php
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
```

---

## 3. Cara Me-regenerasi File Dokumentasi

Setiap kali Anda menambah rute baru atau mengubah definisi anotasi di controller, Anda harus me-regenerasi JSON schema Swagger agar pembaruan muncul di UI.

Jalankan perintah Artisan berikut di terminal proyek:
```bash
php artisan l5-swagger:generate
```

Perintah ini akan men-scan berkas di [Modules/Core/app/Http/Controllers/api](file:///c:/laragon/www/PJBL-EUYY/Modules/Core/app/Http/Controllers/api) (seperti yang dikonfigurasi di `config/l5-swagger.php`) dan memperbarui file skema [storage/api-docs/api-docs.json](file:///c:/laragon/www/PJBL-EUYY/storage/api-docs/api-docs.json).
