# Dokumentasi Arsitektur Sistem (Architecture)

Dokumen ini menjelaskan struktur arsitektur **Modular Monolith** yang digunakan pada **Portal Karya TRPL SV IPB** untuk memandu developer lain memahami pembagian domain, pola komunikasi antar modul, dan desain database.

---

## 1. Arsitektur Modular Monolith
Aplikasi ini tidak menggunakan struktur Laravel Monolith konvensional yang meletakkan semua file di folder `app/`. Sebagai gantinya, sistem dibagi menjadi sub-sistem atau domain bisnis mandiri yang disebut **Modul** di dalam direktori `Modules/`.

### 1.1. Mengapa Modular Monolith?
1. **Pemisahan Kepentingan (Separation of Concerns)**: Setiap modul memiliki tanggung jawab bisnis yang jelas dan terisolasi.
2. **Skalabilitas Tim**: Developer yang berbeda dapat mengerjakan modul yang berbeda (misal: Modul Karya vs Modul Akademik) dengan risiko konflik kode yang minim.
3. **Kemudahan Transisi**: Jika di masa mendatang salah satu modul (misal Modul Karya) mengalami beban traffic yang sangat tinggi, modul tersebut dapat dengan mudah diekstrak menjadi microservice independen karena batas-batas domainnya sudah terdefinisi dengan jelas.

---

## 2. Struktur Modul & Batasan Domain
Sistem dibagi menjadi 4 modul utama:

```
Modules/
├── Core/          # Modul Utama (Home, About, FAQ, logs & visitor tracking)
├── Auth/          # Modul Otentikasi & Registrasi
├── Karya/         # Modul Pengajuan, Review, & Validasi Karya
└── Akademik/      # Modul Profil Dosen, Kurikulum Mata Kuliah, & Berita
```

Setiap modul memiliki struktur internal sebagai berikut (mengikuti konvensi `laravel-modules`):
```text
Modules/NamaModul/
├── app/
│   ├── Http/
│   │   ├── Controllers/   # Kontroler spesifik domain
│   │   └── Requests/      # Kelas validasi FormRequest
│   ├── Models/            # Definisi Model Eloquent & Relasi Database
│   └── Providers/         # Service Providers untuk pendaftaran rute & views modul
├── database/
│   ├── migrations/        # Migrasi database spesifik modul
│   └── seeders/           # Seeder data awal spesifik modul
├── routes/
│   ├── web.php            # Dinonaktifkan (logika dipusatkan di root)
│   └── api.php            # Dinonaktifkan (logika dipusatkan di root)
├── resources/
│   └── views/             # File Blade template spesifik modul
└── tests/
    └── Feature/           # Feature tests untuk pengujian modul
```

> [!NOTE]
> **Sentralisasi Rute**: Walaupun package `laravel-modules` membuat folder `routes/` secara otomatis di tiap modul, proyek ini **menonaktifkan** rute lokal modul tersebut. Rute aplikasi dipusatkan secara terpadu di tingkat root:
> - Rute Halaman Web & Dashboard Admin didefinisikan di [routes/web.php](file:///c:/laragon/www/PJBL-EUYY/routes/web.php).
> - Rute REST API v1 didefinisikan di [routes/api.php](file:///c:/laragon/www/PJBL-EUYY/routes/api.php).

---

## 3. Komunikasi Antar Modul & Dependensi
Untuk menjaga kelonggaran hubungan (*loose coupling*), komunikasi antar modul harus dibatasi:
- **Modul Karya** bergantung pada **Modul Auth** untuk informasi otentikasi uploader dan reviewer (`Auth::user()`).
- **Modul Akademik** bergantung pada **Modul Core** untuk dashboard admin terpadu.
- Gunakan database relasional (foreign keys) secara bijaksana untuk menghubungkan tabel antar modul. Contoh: tabel `karyas` (Modul Karya) memiliki `uploader_id` yang merujuk pada tabel `users` (Modul Auth).

---

## 4. Desain Database & Skema Indeks
Berikut adalah aspek penting dalam desain database yang harus dipertahankan:

### 4.1. SoftDeletes (Penghapusan Logis)
Tabel kritis seperti `karyas`, `dosens`, dan `beritas` dilengkapi dengan fitur `SoftDeletes`.
- Saat data dihapus, kolom `deleted_at` terisi tanda waktu, dan data tidak benar-benar hilang dari database.
- Admin dapat memulihkan (*restore*) atau menghapus secara permanen dari menu Trash.
- Gunakan query `$query->withTrashed()` atau `$query->onlyTrashed()` di controller dashboard admin jika diperlukan.

### 4.2. Database Indexing (Optimasi Query)
Untuk mempercepat pencarian dan filter di halaman galeri karya dan dashboard, pastikan indeks database ditambahkan pada kolom-kolom berikut:
- **`karyas`**: `status_validasi`, `kategori`, `tahun`, `uploader_id`.
- **`log_visitors`**: `ip_address`, `visited_at`.
- **`reviews`**: `karya_id`, `user_id`.

### 4.3. Strategi Caching & Invalidation
Sistem menerapkan query caching untuk data statis/lambat di sisi user guna meminimalkan query database berulang:
- **`dosen_all`**: Menyimpan data seluruh dosen. Cache ini di-invalidasi ketika data dosen ditambah, diubah, atau dihapus di [DosenController.php](file:///c:/laragon/www/PJBL-EUYY/Modules/Akademik/app/Http/Controllers/admin/DosenController.php).
- **`mata_kuliah_user`**: Menyimpan data kurikulum mata kuliah per semester. Cache ini di-invalidasi ketika data mata kuliah dimodifikasi di [MataKuliahController.php](file:///c:/laragon/www/PJBL-EUYY/Modules/Akademik/app/Http/Controllers/admin/MataKuliahController.php).
- **`profil_prodi`**: Menyimpan profil informasi program studi. Cache ini di-invalidasi ketika data profil diperbarui di [ProfilProdiController.php](file:///c:/laragon/www/PJBL-EUYY/Modules/Core/app/Http/Controllers/admin/ProfilProdiController.php).

---

## 5. Alur Data PWA & Service Worker
Aplikasi diintegrasikan sebagai **Progressive Web App (PWA)**:
- Berkas `public/sw.js` (Service Worker) menangani offline caching untuk aset statis (CSS, Javascript, Logo IPB).
- Berkas `public/manifest.json` mengatur nama aplikasi, ikon, dan warna tema saat diinstal sebagai aplikasi mobile/desktop.
- Ketika ada perubahan aset besar di frontend, pastikan versi cache di `sw.js` diperbarui agar browser klien memuat file terbaru.
