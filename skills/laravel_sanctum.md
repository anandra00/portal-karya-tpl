# 🧠 Laravel Sanctum Token Authentication

Aplikasi **Portal Karya TRPL** menyediakan REST API publik terproteksi. Bagian penulisan (seperti unggah karya baru atau memberikan ulasan) dilindungi menggunakan **Laravel Sanctum** token-based authentication.

---

## 1. Konfigurasi Token & Security Hardening

Sistem Sanctum dikonfigurasi secara ketat dengan aturan keamanan sebagai berikut:
- **Token Expiration**: Token disetel memiliki masa kadaluarsa selama **24 jam (1440 menit)** di `config/sanctum.php`.
- **Rate Limiting API**:
  - Rute API umum dilindungi rate limiter `throttle:60,1` (60 request per menit).
  - Rute login API dilindungi rate limiter ketat `throttle:5,1` (5 request per menit) untuk menangkal brute-force.

---

## 2. Alur Penggunaan Token

### Langkah 1: Mendapatkan Token (API Login)
Lakukan request `POST` ke `/api/v1/login` dengan kredensial user:
```json
// POST /api/v1/login
{
    "email": "mahasiswa@apps.ipb.ac.id",
    "password": "password123"
}
```

Respons sukses akan mengembalikan `token`:
```json
{
    "success": true,
    "message": "Login berhasil",
    "token": "1|AbCdEfGhIjKlMnOpQrStUvWxYz...",
    "user": {
        "id": 3,
        "name": "Mahasiswa IPB",
        "role": "user"
    }
}
```

### Langkah 2: Menggunakan Token Untuk API Tulis
Kirim token tersebut sebagai header `Authorization: Bearer <token>` pada request Anda:
```http
POST /api/v1/karyas HTTP/1.1
Host: pjbl-euyy.test
Authorization: Bearer 1|AbCdEfGhIjKlMnOpQrStUvWxYz...
Content-Type: application/json

{
    "judul": "E-Learning App",
    "kategori": "Web Application",
    "deskripsi": "Aplikasi E-learning mahasiswa TRPL",
    "tim_pembuat": "Ahmad, Susi",
    "tahun": 2026
}
```

---

## 3. Implementasi Kode & Pengujian

### Proteksi Rute API (`routes/api.php`):
Rute tulis dilindungi dengan middleware `auth:sanctum`:
```php
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/karyas', [ApiController::class, 'storeKarya'])->name('api.v1.karyas.store');
    Route::post('/karyas/{id}/reviews', [ApiController::class, 'storeReview'])->name('api.v1.reviews.store');
});
```

### Pembuatan Token di Controller (`ApiController.php`):
```php
$token = $user->createToken('api-token')->plainTextToken;
```

### Pengujian Integrasi (`tests/Feature/ApiSanctumTest.php`):
Tulis test case feature untuk memverifikasi fungsionalitas ini secara otomatis:
```bash
php artisan test --filter=ApiSanctumTest
```
Tes ini mencakup pengujian penolakan request tanpa token (401), simulasi login untuk mendapatkan token, dan verifikasi upload karya menggunakan bearer token tersebut.
