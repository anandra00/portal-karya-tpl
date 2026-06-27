# Product Requirement Document (PRD) - Portal Karya TRPL SV IPB

## 1. Pendahuluan & Latar Belakang
**Portal Karya TRPL SV IPB** adalah platform galeri karya mahasiswa, sistem ulasan/rating, manajemen berita program studi, dan konten akademik Sekolah Vokasi IPB University. Aplikasi ini dirancang menggunakan arsitektur **Modular Monolith** berbasis Laravel 11 untuk memudahkan pengembangan berkelanjutan, performa optimal, dan transisi ke microservices di masa mendatang jika diperlukan.

Tujuan utama sistem ini adalah:
1. Menyediakan wadah terintegrasi untuk mendokumentasikan dan memamerkan karya/project mahasiswa TRPL.
2. Membantu koordinasi akademik antara mahasiswa, dosen, dan admin prodi.
3. Meningkatkan visibilitas dan reputasi akademik program studi TRPL SV IPB melalui berita, kurikulum, dan galeri karya yang dapat diakses publik.

---

## 2. Struktur Pengguna (User Roles & Personas)
Sistem memiliki 4 kategori pengguna dengan hak akses yang berbeda (Role-Based Access Control):

| Role | Deskripsi | Fitur Utama |
| --- | --- | --- |
| **Superadmin** | Pengelola sistem tertinggi (IT Administrator). | - Akses penuh ke seluruh menu dashboard admin.<br>- Manajemen backup/restore database.<br>- Manajemen logs aktivitas & jejak audit. |
| **Admin TPL** | Staf program studi atau dosen yang ditunjuk sebagai admin. | - Kelola galeri karya (validasi, hapus/restore dengan SoftDeletes).<br>- Kelola data dosen dan kurikulum mata kuliah.<br>- Kelola berita/kegiatan prodi.<br>- Ekspor laporan statistik & pengunjung ke Excel. |
| **Mahasiswa IPB** | Pengguna terotentikasi menggunakan email akademik IPB (`@apps.ipb.ac.id`). | - Mengunggah karya baru (judul, deskripsi, preview, file pendukung, link repositori, tim).<br>- Melihat riwayat pengajuan karya beserta status moderasi.<br>- Memberikan ulasan/rating pada karya mahasiswa lain. |
| **User Umum** | Pengunjung umum atau mahasiswa non-IPB (`@gmail.com` dll). | - Menjelajahi galeri karya terbit (`accepted`).<br>- Membaca berita & kurikulum prodi.<br>- Mengakses daftar dosen dan FAQ prodi. |

---

## 3. Spesifikasi Fungsional (Functional Requirements)

### 3.1. Landing Page & FAQ
- Menampilkan visualisasi premium dengan dukungan Dark Mode instan (tanpa efek flash).
- Statistik ringkas jumlah karya, dosen, dan mata kuliah.
- Daftar karya terpopuler (berdasarkan rating) dan berita terbaru.
- **Pencarian FAQ Interaktif**: Memungkinkan pencarian instan berbasis client-side (Alpine.js) dengan tetap menjaga SEO friendly (HTML dirender di server).

### 3.2. Manajemen Otentikasi (Module Auth)
- Registrasi mandiri mahasiswa (validasi domain email `@apps.ipb.ac.id` untuk izin unggah).
- Login dan logout yang aman.
- Fitur reset password melalui link verifikasi email.

### 3.3. Galeri & Pengajuan Karya (Module Karya)
- **Unggah Karya**: Formulir unggah dengan validasi file (PDF untuk laporan/dokumen, PNG/JPG untuk preview visual, link repositori github/video demo).
- **Sistem Validasi Admin**: Setiap karya yang diunggah masuk ke status `pending`. Admin dapat menerima (`accepted`) atau menolak (`rejected`) karya dengan catatan.
- **Sistem Ulasan (Review)**: Mahasiswa dan Dosen yang terotentikasi dapat memberikan rating bintang (1-5) dan komentar ulasan tertulis pada karya yang telah diterima.
- **SoftDeletes**: Fitur pemulihan karya yang dihapus secara tidak sengaja melalui menu Trash di dashboard admin.

### 3.4. Manajemen Data Akademik (Module Akademik)
- **Data Dosen**: Menampilkan profil lengkap dosen prodi beserta minat riset (*research interest*).
- **Mata Kuliah**: Informasi kurikulum mata kuliah aktif per semester.
- **Berita & Kegiatan**: Publikasi artikel berita/kegiatan terbaru prodi oleh admin.

### 3.5. Jejak Audit & Ekspor Laporan
- **Visitor Logger**: Mencatat aktivitas kunjungan unik ke halaman utama untuk laporan statistik bulanan.
- **Activity Log**: Mencatat perubahan krusial yang dilakukan oleh admin (seperti validasi karya, tambah dosen/berita, hapus data) sebagai jejak audit.
- **Ekspor Excel**: Pembuatan laporan dinamis berformat `.xlsx` (menggunakan PhpSpreadsheet) dengan layout premium, penyesuaian lebar kolom otomatis, dan pewarnaan status.

---

## 4. Spesifikasi Non-Fungsional (Non-Functional Requirements)

### 4.1. Arsitektur & Struktur Kode
- Menggunakan pola **Modular Monolith** dengan package `nwidart/laravel-modules`. Pembagian modul: `Core`, `Auth`, `Karya`, `Akademik`.
- Pemisahan aturan validasi menggunakan Laravel `FormRequest` khusus untuk menjaga Controller tetap bersih.

### 4.2. Keamanan & Kredensial
- Otorisasi rute dashboard menggunakan middleware bawaan Laravel dengan verifikasi role.
- Proteksi CSRF di setiap request formulir.
- Enkripsi kata sandi menggunakan bcrypt.

### 4.3. Performa & Optimasi
- **Eager Loading**: Wajib menggunakan `with()` saat memuat relasi (seperti karya dengan uploader & reviews) untuk mencegah masalah **N+1 Query**.
- **Caching**: Menggunakan caching dinamis dengan `Cache::remember` untuk query lambat atau data statis (seperti data Dosen & statistik global).
- **Indexing Database**: Menambahkan indeks pada kolom filter kritis seperti `status_validasi`, `kategori`, dan `tahun`.

### 4.4. UI/UX & PWA
- Desain modern minimalis berbasis Tailwind CSS dengan tipografi **Outfit & Inter**.
- Pendekatan **Mobile First Responsive Layout**.
- Integrasi PWA (Progressive Web App) dengan service worker (`sw.js`) dan manifest JSON agar dapat diinstal di perangkat mobile.

---

## 5. Rencana Rilis & Fase Pengembangan
Sistem dikembangkan secara bertahap untuk memastikan stabilitas:
- **Fase 1 (MVP - Terpenuhi)**: Sistem Core, Auth dasar, Unggah Karya, Validasi Admin, dan FAQ instan.
- **Fase 2 (Optimalisasi - Terpenuhi)**: Eager loading, Caching, Audit Logs, SoftDeletes, dan Ekspor Excel.
- **Fase 3 (Pengembangan Lanjutan - Masa Depan)**:
  - Integrasi SSO IPB IAM (OAuth2/OIDC).
  - Migrasi local storage ke Cloud Object Storage (AWS S3) & CDN.
  - Notifikasi real-time menggunakan WebSockets (Laravel Reverb / Pusher).
  - Moderasi otomatis berkas/gambar menggunakan Machine Learning API.
