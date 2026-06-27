# 🧠 Caveman Debugging & Logging Guide

Panduan taktis untuk melakukan debugging cepat di sistem **Portal Karya TRPL** tanpa menggunakan debugger kompleks (seperti Xdebug), melainkan memanfaatkan teknik logging dasar, dump & die, dan penelusuran WebSocket Reverb.

---

## 1. Dump, Die & Debugging HTTP (`dd` & `dump`)

Laravel menyediakan helper global `dd()` (Dump and Die) dan `dump()` untuk melihat isi variabel atau request secara instan.

### Penggunaan Dasar di Controller / Action:
```php
public function storeKarya(Request $request)
{
    // Menghentikan eksekusi dan melihat seluruh data request
    dd($request->all());

    // Menghentikan eksekusi dan melihat satu model objek
    $user = auth()->user();
    dd($user);
}
```

### Tips Caveman Debugging untuk AJAX/API:
Jika kamu melakukan `dd()` di rute API atau AJAX request, output HTML `dd` mungkin akan merusak respons. Untuk API, gunakan response JSON manual:
```php
return response()->json([
    'debug_user' => auth()->user(),
    'request_data' => $request->all()
], 500);
```

---

## 2. Laravel Log File System

File log utama berada di [storage/logs/laravel.log](file:///c:/laragon/www/PJBL-EUYY/storage/logs/laravel.log).

### Menulis Log Baru:
Gunakan facade `Log` untuk mencatat data sensitif atau melacak alur eksekusi tanpa mengganggu jalannya aplikasi:
```php
use Illuminate\Support\Facades\Log;

Log::info('Pengguna mengunggah karya.', [
    'user_id' => auth()->id(),
    'karya_judul' => $karya->judul
]);

Log::error('Koneksi WebSocket gagal: ' . $exception->getMessage());
```

### Membaca Log Secara Real-time (Tail):
Gunakan perintah terminal untuk memantau pembaruan log secara live saat kamu berinteraksi dengan website:
```bash
# Laravel Pail (rekomendasi Laravel 11+)
php artisan pail

# PowerShell tail manual
Get-Content -Path .\storage\logs\laravel.log -Tail 50 -Wait
```

---

## 3. Real-time WebSockets & Reverb Debugging

Untuk menelusuri apakah koneksi WebSocket Reverb dan Echo bekerja dengan baik:

### Aktifkan Debug Mode di Reverb:
Jalankan server Reverb dengan flag `--debug` untuk melihat frame event masuk dan keluar di terminal secara detail:
```bash
php artisan reverb:start --debug
```

### Debug Melalui Browser Console (Echo & Pusher):
Buka tab **Console** di developer tools browser Anda (F12) lalu ketik kode berikut untuk memeriksa status objek Echo global:
```javascript
// Cek status koneksi Echo
console.log(window.Echo);

// Cek apakah channel private tersambung
console.log(window.Echo.connector.channels);
```
Anda juga bisa membuka tab **Network** -> **WS** (WebSockets) di browser untuk memantau frame koneksi websocket (`App.Models.User.{id}`) yang dikirim secara langsung.

---

## 4. Visitor Logging & Jejak Audit (Database Logs)

Sistem ini memiliki log aktivitas internal yang disimpan ke dalam database. Kamu bisa mengeceknya langsung melalui panel admin:
- **Visitor Log**: Mencatat rute-rute publik yang dikunjungi pengunjung anonim. Cek controller `LogVisitor` middleware.
- **Activity Log**: Mencatat aksi-aksi administratif yang dilakukan admin dan superadmin (seperti menyetujui karya, menghapus data). Akses via `/admin/activity-logs`.
