# 🧠 Modular Monolith Architecture (laravel-modules)

Aplikasi **Portal Karya TRPL** dikembangkan dengan struktur arsitektur **Modular Monolith** menggunakan package `nwidart/laravel-modules`. Pendekatan ini memisahkan fitur/domain proyek ke dalam modul-modul independen yang terisolasi dengan rapi daripada menumpuk semuanya di folder `app/` bawaan Laravel.

---

## 1. Struktur Folder Modular

Setiap modul memiliki struktur lengkap seperti aplikasi Laravel mini. Modul-modul proyek ini disimpan di folder `/Modules/`:
- **`Modules/Core`**: Mengatur dashboard admin, profil instansi prodi, jejak audit, logging visitor, dan halaman statis umum (Home, FAQ, Tentang).
- **`Modules/Auth`**: Mengatur alur login web, registrasi mahasiswa, verifikasi email, dan reset password.
- **`Modules/Karya`**: Mengatur data karya mahasiswa, pengunggahan, moderasi/validasi admin, data kategori karya, dan ulasan/review.
- **`Modules/Akademik`**: Mengatur data dosen prodi, mata kuliah, dan pengelolaan konten berita & kegiatan.

### Struktur Anatomi dalam Modul (contoh `Modules/Core`):
```text
Modules/Core/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   └── Middleware/
│   ├── Models/
│   └── Providers/
├── config/
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   └── views/
└── routes/
    ├── web.php
    └── api.php
```

---

## 2. Autoloading & Konfigurasi

Modul-modul didaftarkan secara otomatis melalui Composer menggunakan `wikimedia/composer-merge-plugin` untuk menggabungkan dependensi di masing-masing modul:
- `composer.json` utama menyertakan `"Modules/*/composer.json"` untuk di-merge secara otomatis.
- File konfigurasi status modul disimpan di [modules_statuses.json](file:///c:/laragon/www/PJBL-EUYY/modules_statuses.json) di root proyek.

---

## 3. Perintah Artisan Modular yang Sering Digunakan

Gunakan perintah CLI berikut untuk mengelola modul selama pengembangan:

### Membuat Modul Baru:
```bash
php artisan module:make NamaModul
```

### Membuat Controller/Model Khusus Modul:
```bash
php artisan module:make-controller NamaController NamaModul
php artisan module:make-model NamaModel NamaModul
```

### Membuat Migrasi Khusus Modul:
```bash
php artisan module:make-migration create_nama_table NamaModul
```

### Menjalankan Migrasi Modul:
```bash
# Menjalankan migrasi seluruh modul
php artisan module:migrate

# Menjalankan database seeder seluruh modul
php artisan module:seed
```
