# Portal TPL SV IPB (PJBL-EUYY)

Portal ini adalah sistem informasi berbasis web untuk Program Studi Teknologi Rekayasa Perangkat Lunak (TPL) Sekolah Vokasi IPB. Aplikasi ini berfungsi sebagai wadah untuk menampilkan karya mahasiswa, profil dosen, berita prodi, mata kuliah, dan informasi akademik lainnya.

> **Tagline:** "Syntax Error? Compile Lagi!"

## 🌟 Fitur Utama

### 👥 Halaman Pengunjung (Public)
* **Beranda:** Menampilkan video profil, highlight karya mahasiswa, dan berita terbaru.
* **Tentang Kami:** Visi, Misi, Tujuan, dan Capaian Program Studi.
* **Dosen:** Daftar profil dosen pengajar.
* **Mata Kuliah:** Informasi kurikulum dan mata kuliah.
* **Karya Mahasiswa:** Galeri hasil karya/proyek mahasiswa dengan fitur filter kategori.
* **Detail Karya:** Informasi detail proyek, tim pembuat, dan ulasan/rating.
* **Berita:** Kabar terbaru seputar prodi TPL.
* **FAQ:** Pertanyaan yang sering diajukan.

### 🔐 Panel Admin (Dashboard)
* **Dashboard:** Ringkasan statistik sistem.
* **Kelola Karya:** Validasi ajuan karya mahasiswa (Submission, Accepted, Rejected).
* **Kelola Berita:** CRUD (Create, Read, Update, Delete) untuk artikel berita.
* **Kelola Dosen:** Manajemen data dosen.
* **Kelola Mata Kuliah:** Manajemen data mata kuliah.
* **Kelola Info Prodi:** Edit visi, misi, dan video profil.
* **Manajemen Admin:** Kelola akun administrator.
* **Validasi Konten:** Memeriksa dan menyetujui konten sebelum dipublikasi.

## 🛠️ Teknologi yang Digunakan

* **Framework:** [Laravel 11.x](https://laravel.com)
* **Bahasa:** PHP 8.2+
* **Database:** MySQL
* **Frontend:**
    * Blade Templating Engine
    * Bootstrap 5 (Layouting utama)
    * Tailwind CSS (Konfigurasi terdeteksi)
    * Custom CSS (`public/css/`)
* **Icons:** Feather Icons, Bootstrap Icons
* **Authentication:** Laravel Breeze / Built-in Auth

## 📋 Prasyarat Sistem

Sebelum menjalankan proyek ini, pastikan komputer Anda memiliki:
* PHP >= 8.2
* Composer
* MySQL / MariaDB
* Node.js & NPM (untuk compile asset)

## 🚀 Cara Instalasi

Ikuti langkah-langkah berikut untuk menjalankan proyek di komputer lokal Anda:

1.  **Clone Repositori**
    ```bash
    git clone [https://github.com/username/pjbl-euyy.git](https://github.com/username/pjbl-euyy.git)
    cd pjbl-euyy
    ```

2.  **Install Dependensi PHP**
    ```bash
    composer install
    ```

3.  **Install Dependensi Frontend**
    ```bash
    npm install
    ```

4.  **Konfigurasi Environment**
    * Salin file `.env.example` menjadi `.env`:
        ```bash
        cp .env.example .env
        ```
    * Buka file `.env` dan sesuaikan konfigurasi database Anda:
        ```env
        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=nama_database_anda
        DB_USERNAME=root
        DB_PASSWORD=
        ```

5.  **Generate App Key**
    ```bash
    php artisan key:generate
    ```

6.  **Migrasi Database & Seeder**
    Jalankan perintah ini untuk membuat tabel dan mengisi data awal (akun admin default, kategori, prodi, dll):
    ```bash
    php artisan migrate --seed
    ```

7.  **Jalankan Aplikasi**
    Buka dua terminal terpisah:
    * Terminal 1 (Server PHP):
        ```bash
        php artisan serve
        ```
    * Terminal 2 (Compile Assets - Optional jika pakai Vite/Tailwind):
        ```bash
        npm run dev
        ```

8.  **Akses Aplikasi**
    Buka browser dan kunjungi: `http://localhost:8000`

## 📂 Struktur Folder Penting

* `app/Models` - Definisi struktur data (Karya, Dosen, Berita, dll).
* `app/Http/Controllers/admin` - Logika untuk halaman dashboard admin.
* `resources/views/pages` - Tampilan halaman depan (Public).
* `resources/views/admin` - Tampilan halaman dashboard admin.
* `public/css` - File CSS kustom untuk styling spesifik per halaman.
* `database/seeders` - Data awal untuk pengujian.

## 🤝 Kontribusi

Tim Pengembang:
* **Radithtzy0890** (Owner)
* *Tambahkan nama anggota tim lain di sini*

## 📝 Lisensi

Proyek ini dibuat untuk keperluan tugas Project Based Learning (PBL) Sekolah Vokasi IPB.

## 🌟 Fitur Aplikasi

Aplikasi ini dibagi menjadi dua modul utama: Halaman Publik (untuk Pengunjung/Mahasiswa) dan Panel Admin (untuk Pengelola).

### 👥 Halaman Publik (User & Visitor)
Fitur yang dapat diakses oleh mahasiswa atau pengunjung umum:

* **Otentikasi Pengguna**
    * Login, Register, dan Lupa Password (Reset Password).
    * Verifikasi Email.
* **Beranda (Home)**
    * Menampilkan video profil program studi.
    * *Highlight* karya mahasiswa terbaru dan berita terkini.
* **Profil Program Studi (Tentang Kami)**
    * Informasi Visi, Misi, Tujuan, dan Capaian Pembelajaran Lulusan.
    * Video profil interaktif.
* **Direktori Dosen**
    * Daftar profil lengkap dosen pengajar di TPL SV IPB.
* **Informasi Akademik**
    * Daftar Mata Kuliah dan kurikulum yang diajarkan.
* **Portal Karya Mahasiswa**
    * **Galeri Karya:** Menampilkan daftar proyek/karya mahasiswa dengan filter kategori.
    * **Detail Karya:** Halaman khusus untuk setiap karya yang memuat deskripsi, tim pembuat, dan pratinjau (gambar/dokumen).
    * **Unggah Karya:** Fitur bagi mahasiswa untuk mengajukan karya mereka (memerlukan login).
    * **Ulasan & Rating:** Pengguna yang login dapat memberikan bintang dan komentar pada karya.
* **Berita & Pengumuman**
    * Artikel berita terbaru seputar kegiatan prodi.
* **FAQ**
    * Daftar pertanyaan yang sering diajukan beserta jawabannya.

### 🛠️ Panel Admin (Dashboard)
Fitur manajemen untuk administrator prodi:

* **Dashboard Statistik**
    * Ringkasan jumlah karya, berita, dosen, dan aktivitas pengunjung.
* **Manajemen Karya (Validation Flow)**
    * **Validasi:** Memeriksa karya yang baru diunggah mahasiswa (Status: *Submission*, *Accepted*, *Rejected*).
    * **Kelola Data:** Edit atau hapus data karya yang sudah ada.
* **Manajemen Konten Website**
    * **Kelola Berita:** Tambah, edit, dan hapus artikel berita.
    * **Kelola Dosen:** Manajemen data profil dosen (Nama, NIDN, Foto, Bidang Keahlian).
    * **Kelola Mata Kuliah:** Manajemen data mata kuliah (Nama, SKS, Semester, Deskripsi).
    * **Kelola Info Prodi:** Edit teks Visi, Misi, Capaian, dan link Video Profil tanpa coding.
    * **Kelola Kontak/Pesan:** Melihat pesan masuk dari pengunjung.
* **Manajemen Pengguna**
    * **Kelola Admin:** Menambah atau menghapus akun administrator.
    * **Daftar Pengunjung:** Melihat log aktivitas atau statistik pengunjung (*Activity Logs*).
* **Manajemen Ulasan**
    * Moderasi ulasan yang masuk pada karya mahasiswa.