# Daftar Akun & Kredensial Sistem (Seeded Users)

Berikut adalah daftar akun default yang terdaftar di database setelah menjalankan seeder (`php artisan db:seed` atau `php artisan migrate:fresh --seed`):

| Nama Pengguna | Email | Password | Role / Hak Akses | Keterangan |
| --- | --- | --- | --- | --- |
| **Superadmin** | `superadmin@gmail.com` | `password123` | `superadmin` | Memiliki akses penuh ke panel admin, termasuk menu backup database. |
| **Admin TPL** | `admin@tpl.svipb.ac.id` | `password123` | `admin` | Memiliki akses ke panel admin untuk mengelola karya, dosen, berita, dll. |
| **Mahasiswa IPB** | `mahasiswa@apps.ipb.ac.id` | `password123` | `user` | Menggunakan email akademik IPB. Diizinkan untuk mengunggah karya mahasiswa. |
| **User Umum** | `user@gmail.com` | `password123` | `user` | Menggunakan email umum. Diizinkan masuk web tetapi dibatasi dari mengunggah karya. |

---

### Cara Menggunakan

1. Jalankan server lokal: `php artisan serve` & `npm run dev`.
2. Buka aplikasi di web browser [http://127.0.0.1:8000](http://127.0.0.1:8000).
3. Klik menu **Masuk** (Login) di pojok kanan atas.
4. Masukkan salah satu email dan password di atas untuk mencoba berbagai fungsionalitas sistem (seperti unggah karya atau kelola dashboard admin).
