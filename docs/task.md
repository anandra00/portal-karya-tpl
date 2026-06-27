# Project Tasks & Development Roadmap

Dokumen ini berisi daftar tugas, status pengembangan, dan roadmap untuk sistem **Portal Karya TRPL SV IPB**.

---

## 🛠️ Fase 1: Setup Awal & Fondasi Sistem (Core & Auth)
*Status: Selesai*

- [x] Inisialisasi proyek Laravel 11 dengan struktur **Modular Monolith** (`nwidart/laravel-modules`).
- [x] Konfigurasi environment awal (`.env`, koneksi database, app key).
- [x] Pembuatan dan pembagian 4 modul utama:
  - [x] `Modules/Core`
  - [x] `Modules/Auth`
  - [x] `Modules/Karya`
  - [x] `Modules/Akademik`
- [x] Implementasi sistem otentikasi (Register, Login, Logout, Reset Password via Email).
- [x] Validasi pendaftaran mahasiswa khusus menggunakan email akademik IPB (`@apps.ipb.ac.id`).
- [x] Desain landing page utama dengan sistem Dark Mode (anti-flash script) dan tipografi premium.
- [x] Implementasi pencarian FAQ instan berbasis client-side dengan Alpine.js (SEO-friendly).

---

## 📂 Fase 2: Fitur Utama & Dashboard Admin
*Status: Selesai*

- [x] Pembuatan skema database dan migrasi untuk model `Karya`, `Dosen`, `MataKuliah`, `Review`, dan `LogVisitor`.
- [x] Implementasi sistem unggah karya mahasiswa (upload PDF, gambar preview, link github/video).
- [x] Pembuatan dashboard admin untuk mengelola pengajuan karya (validasi setujui/tolak).
- [x] Fitur rating bintang dan ulasan komentar untuk karya yang sudah terbit.
- [x] Implementasi **SoftDeletes** dan menu Trash untuk karya mahasiswa, dosen, dan berita.
- [x] Pembuatan sistem Jejak Audit (*Audit Trace Logs*) untuk memantau aktivitas admin.
- [x] Integrasi fitur ekspor data ke format Excel (.xlsx) dengan styling premium menggunakan PhpSpreadsheet.
- [x] Konfigurasi dan aktivasi PWA (Progressive Web App) dengan service worker (`sw.js`).

---

## 🚀 Fase 3: Optimasi Performa & Pengujian
*Status: Selesai & Berkelanjutan*

- [x] Eliminasi masalah **N+1 Query** pada relasi model Karya, Review, dan User menggunakan Eager Loading (`with()`).
- [x] Implementasi Caching (`Cache::remember`) untuk data dosen, statistik dashboard, dan FAQ.
- [x] Penambahan indeks database pada kolom-kolom pencarian kritis (`status_validasi`, `kategori`, `tahun`).
- [x] Pemisahan aturan validasi dari controller ke file `FormRequest` khusus.
- [x] Pembuatan Feature Tests untuk menguji:
  - [x] Halaman publik (respons status 200).
  - [x] Hak akses / otorisasi rute (RBAC).
  - [x] Alur pengajuan karya & moderasi admin.
  - [x] Fungsionalitas ekspor laporan Excel.
- [x] Optimasi Caching & Keamanan Tambahan:
  - [x] Pembersihan *dead imports* model yang tidak terpakai di `routes/web.php`.
  - [x] Proteksi endpoint REST API publik menggunakan rate limiter (`throttle:60,1`).
  - [x] Invalidation Cache untuk Dosen (`dosen_all`) saat admin menambah/mengubah/menghapus dosen.
  - [x] Penyelarasan nama method ekspor `exportCsv` menjadi `exportExcel` sesuai dengan tipe file asli (.xlsx).

---

## 🚀 Fase 4: WebSockets & REST API v1 (Laravel Sanctum & Swagger)
*Status: Selesai*

- [x] **Setup Backend WebSockets dengan Laravel Reverb**:
  - [x] Instalasi Laravel Reverb server & penyiaran.
  - [x] Instalasi dependency Echo & Pusher-js.
  - [x] Pembuatan tabel & migrasi database `notifications`.
- [x] **Real-time Notifications**:
  - [x] Pembuatan kelas notifikasi `KaryaStatusNotification` dan `NewReviewNotification`.
  - [x] Pemicuan notifikasi real-time di controller saat status karya diubah dan review baru masuk.
  - [x] Pembuatan menu dropdown Bell Notifikasi di navbar menggunakan Alpine.js & Echo.
  - [x] Pembuatan popup Toast real-time di layout utama.
- [x] **Penyempurnaan API RESTful v1**:
  - [x] Implementasi API token authentication (Laravel Sanctum) untuk rute API tulis (`POST /v1/karyas` & `POST /v1/karyas/{id}/reviews`).
  - [x] Integrasi generator Swagger (`darkaonline/l5-swagger`) dengan UI interaktif di `/api/documentation`.
  - [x] Konfigurasi scan path untuk modul monolit dan penulisan OpenAPI 3.0 annotations menggunakan modern PHP 8 Attributes.
  - [x] Pembuatan Automated Feature Tests untuk Sanctum Auth & alur API-to-notification.
- [x] **QA & Keamanan Sistem (Bugfix & Hardening)**:
  - [x] Perbaikan celah XSS Kritis pada Toast Notification (`app.blade.php`) menggunakan DOM API `textContent`.
  - [x] Perbaikan celah XSS Tinggi pada menu dropdown Notifikasi di Navbar (`navbar.blade.php`) menggunakan Blade `e()` helper.
  - [x] Penerapan masa kedaluwarsa Token Sanctum selama 24 jam (`config/sanctum.php`).
  - [x] Pembatasan brute-force rate limit ketat pada API Login (`throttle:5,1`).
  - [x] Pengamanan dokumentasi Swagger UI dengan middleware hak akses admin/superadmin (`config/l5-swagger.php`).
  - [x] Perbaikan 500 internal server error pada rute list berita `/berita` dengan membuat view khusus `berita_list.blade.php`.
  - [x] Pengamanan hak akses backup database dan manajemen list admin khusus untuk role `superadmin` (`routes/web.php` & `sidebar.blade.php`).

---

## 🔮 Fase 5: Roadmap Masa Depan (Backlog)
*Status: Belum Mulai (Backlog)*

- [ ] **Integrasi Single Sign-On (SSO) IPB IAM**
  - [ ] Analisis dokumentasi protokol IAM IPB (OAuth2 / OIDC).
  - [ ] Implementasi library socialite / provider kustom SSO IPB.
  - [ ] Pengujian otentikasi login sekali-klik menggunakan akun IPB.
- [ ] **Migrasi Penyimpanan ke Cloud Object Storage & CDN**
  - [ ] Konfigurasi package driver filesystem S3 (seperti AWS S3 atau Google Cloud Storage).
  - [ ] Pembaruan kode unggah file agar otomatis disimpan ke bucket cloud.
  - [ ] Integrasi Cloudflare CDN untuk caching visual preview karya mahasiswa.
- [ ] **Sistem Moderasi Karya Otomatis Berbasis Machine Learning**
  - [ ] Integrasi API Computer Vision untuk menyaring gambar preview karya yang tidak pantas (NSFW).
  - [ ] Integrasi API NLP (seperti HuggingFace / OpenAI) untuk menyaring deskripsi karya dari spam atau kata-kata kasar secara otomatis.

