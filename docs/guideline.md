# Panduan Pengembangan & Standar Kode (Guideline)

Dokumen ini berisi pedoman, konvensi, dan standar kode yang harus diikuti oleh setiap developer yang bekerja pada proyek **Portal Karya TRPL SV IPB**. Tujuannya adalah menjaga kualitas kode, konsistensi arsitektur modular, dan mempermudah pemeliharaan sistem.

---

## 1. Konvensi Git & Alur Kerja (Git Workflow)

### 1.1. Penamaan Branch (Branch Naming)
Gunakan format penamaan branch yang deskriptif dan konsisten:
- `feature/nama-fitur` : Untuk pengembangan fitur baru (contoh: `feature/sso-ipb-login`).
- `bugfix/nama-bug` : Untuk perbaikan bug (contoh: `bugfix/fix-excel-export-styling`).
- `hotfix/nama-isu` : Untuk perbaikan darurat di production.
- `refactor/nama-refactor` : Untuk restrukturisasi kode tanpa mengubah fungsionalitas (contoh: `refactor/eager-loading-queries`).

### 1.2. Format Pesan Commit (Conventional Commits)
Setiap commit wajib menggunakan format terstandar:
```text
<type>(<scope>): <subject>
```
**Tipe yang diperbolehkan (`type`):**
- `feat` : Fitur baru untuk user/admin.
- `fix` : Perbaikan bug.
- `docs` : Perubahan dokumentasi (seperti file `.md`).
- `style` : Perubahan kosmetik/formatting tanpa mengubah logika (CSS, penataan spasi, dll).
- `refactor` : Perubahan kode yang tidak menambah fitur atau memperbaiki bug.
- `test` : Menambah atau memperbaiki pengujian (Feature/Unit tests).
- `chore` : Pembaruan build tooling, dependencies, atau konfigurasi server.

*Contoh:*
```bash
git commit -m "feat(karya): add soft deletes to karya validation screen"
git commit -m "fix(excel): resolve auto-column width bug in VisitorExport"
```

---

## 2. Standar Kode Backend (PHP & Laravel)

### 2.1. Standar PSR
- Proyek ini mematuhi standar coding **PSR-12** untuk PHP.
- Gunakan indentation **4 spasi** (bukan tab).
- Pastikan deklarasi tipe data (`type hinting`) digunakan pada parameter fungsi dan nilai kembalian (*return types*) jika memungkinkan.

### 2.2. Pola Arsitektur Modular Monolith
- Semua logika domain spesifik harus diletakkan di dalam direktori `Modules/`.
- Hindari menulis logika bisnis di folder `app/` bawaan Laravel, kecuali untuk konfigurasi global, global middleware, atau provider dasar.
- Setiap modul harus mandiri (*self-contained*) dengan Controller, Model, Migration, FormRequest, dan Views masing-masing. Namun, rute lokal modul dinonaktifkan dan pendefinisian rute dipusatkan di berkas root: [routes/web.php](file:///c:/laragon/www/PJBL-EUYY/routes/web.php) untuk web/admin, dan [routes/api.php](file:///c:/laragon/www/PJBL-EUYY/routes/api.php) untuk REST API.

### 2.3. Controller & Validasi (FormRequests)
- **Thin Controllers**: Controller hanya bertugas menerima input, memanggil service/model, dan mengembalikan respon/view. Hindari menulis logika bisnis yang panjang di dalam Controller.
- **FormRequest Separation**: Jangan lakukan validasi di dalam controller menggunakan `$request->validate()`. Buatlah file `FormRequest` khusus di dalam modul terkait.
  
*Contoh:*
```php
// Bagus - Logika validasi terpisah
public function store(StoreKaryaRequest $request)
{
    $validated = $request->validated();
    $this->karyaService->create($validated);
    return redirect()->route('karya.index')->with('success', 'Karya berhasil diajukan!');
}
```

### 2.4. Pencegahan Masalah N+1 Query (Eager Loading)
- Saat mengambil data relasi (seperti karya beserta uploader atau reviews), selalu gunakan metode `with()` untuk memuat relasi terlebih dahulu (*Eager Loading*).
- Dilarang keras melakukan perulangan query di dalam Blade view.

*Contoh:*
```php
// Salah (Memicu N+1 Query)
$karyas = Karya::all(); // Di Blade: $karya->user->name (akan memicu query baru per baris)

// Benar (Hanya 2 query secara total)
$karyas = Karya::with(['user', 'reviews'])->get();
```

### 2.5. Caching & Database Indexing
- Gunakan `Cache::remember()` untuk data yang jarang berubah namun sering diakses (seperti daftar Dosen atau FAQ).
- **Cache Invalidation**: Setiap kali data yang di-cache mengalami perubahan (tambah/update/delete), cache tersebut **wajib** dihapus menggunakan `Cache::forget('key')` di dalam controller agar data yang disajikan ke pengguna tetap aktual.
- Kolom database yang digunakan di klausa `WHERE`, `ORDER BY`, atau filter pencarian wajib ditambahkan indeks (`index`) pada file migrasi.

---

## 3. Standar Kode Frontend (HTML, CSS, & Javascript)

### 3.1. Tipografi & Desain System
- Proyek ini menggunakan font Google **Outfit** dan **Inter**. Pastikan elemen UI menggunakan font ini.
- Gunakan utility classes dari **Tailwind CSS** untuk konsistensi layout, warna, dan spasi.
- **Glassmorphism**: Gunakan kombinasi `bg-opacity`, `backdrop-blur`, dan border tipis transparan untuk elemen UI premium.

### 3.2. Dark Mode Implementation
- Sistem mendukung Dark Mode instan. Gunakan class selector Tailwind `dark:` untuk mengatur tampilan mode gelap.
- Pastikan tidak ada efek kedipan visual (*flash of light mode*) saat halaman dimuat dengan meletakkan anti-flash script di `<head>` dokumen HTML.

### 3.3. Interaktivitas Client-Side (Alpine.js)
- Gunakan **Alpine.js** untuk komponen interaktif ringan seperti toggle menu, dropdown, modal, dan filter pencarian instan (FAQ).
- Untuk performa SEO yang optimal, render data statis dari server (Laravel Blade) terlebih dahulu, kemudian gunakan Alpine.js untuk memanipulasi tampilannya di client-side.

---

## 4. Pengujian & Penjaminan Mutu (Testing)
- Setiap kali menambahkan fitur baru atau melakukan refactoring besar, developer wajib menjalankan test suite lokal:
  ```bash
  php artisan test
  ```
- Buat file test baru di direktori `Modules/NamaModul/Tests/` jika modul baru ditambahkan.
- Semua pengujian rute yang memerlukan login wajib mensimulasikan user dengan role yang sesuai (`superadmin`, `admin`, atau `user`).
