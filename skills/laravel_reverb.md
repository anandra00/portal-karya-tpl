# 🧠 Laravel Reverb & Real-time WebSockets Integration

Sistem **Portal Karya TRPL** mengintegrasikan **Laravel Reverb** sebagai server WebSocket utama dan **Laravel Echo** untuk penyiaran notifikasi real-time di sisi pengguna tanpa perlu reload halaman.

---

## 1. Arsitektur Event & Notifikasi

Penyebaran notifikasi menggunakan sistem Database + Broadcast channel:
- Database: Notifikasi disimpan di tabel `notifications` untuk riwayat persisten.
- Broadcast: Notifikasi didorong secara instan melalui koneksi WebSocket pribadi (`private-App.Models.User.{id}`).

### Kelas Notifikasi Utama:
1.  **[KaryaStatusNotification](file:///c:/laragon/www/PJBL-EUYY/Modules/Karya/app/Notifications/KaryaStatusNotification.php)**: Mengirim info ke uploader ketika status validasi karyanya diubah oleh Admin.
2.  **[NewReviewNotification](file:///c:/laragon/www/PJBL-EUYY/Modules/Karya/app/Notifications/NewReviewNotification.php)**: Mengirim info ke uploader karya ketika ada pengguna lain yang memberikan review/rating bintang.

---

## 2. Cara Kerja Penyiaran (Broadcast)

### Sisi Backend (Pemicu Notifikasi):
```php
// Mengirim notifikasi ke user (akan tersimpan ke DB & ter-broadcast)
$karya->user->notify(new \Modules\Karya\Notifications\KaryaStatusNotification($karya));
```

### Sisi Frontend (Listener / Client-side):
Laravel Echo diinisialisasi secara global di [resources/js/echo.js](file:///c:/laragon/www/PJBL-EUYY/resources/js/echo.js).

Di [navbar.blade.php](file:///c:/laragon/www/PJBL-EUYY/resources/views/partials/navbar.blade.php), kita mendengarkan channel notifikasi pribadi milik pengguna yang sedang login:
```javascript
window.Echo.private('App.Models.User.{{ Auth::id() }}')
    .notification((notification) => {
        // 1. Tambahkan unread count badge
        this.unreadCount++;
        
        // 2. Unshift objek notifikasi baru ke array Alpine.js untuk memperbarui list dropdown secara reaktif
        this.notifications.unshift({
            id: notification.id,
            message: notification.message,
            link: notification.link || '#',
            read: false,
            created_at: 'Baru saja'
        });

        // 3. Tampilkan Toast Popup mengambang secara premium
        if (window.showNotificationToast) {
            window.showNotificationToast(notification.message, notification.link);
        }
    });
```

---

## 3. Cara Menjalankan Layanan (Development & Production)

### Langkah 1: Compile Assets
Pastikan assets JS dikompilasi (termasuk modul Echo):
```bash
npm run build
```

### Langkah 2: Jalankan Queue Worker (Opsional tetapi Disarankan)
Karena notifikasi mengimplementasikan `ShouldQueue`, disarankan menjalankan antrean secara asynchronous:
```bash
php artisan queue:work
```

### Langkah 3: Jalankan Server Reverb
Jalankan server WebSocket lokal:
```bash
php artisan reverb:start
```
Default server Reverb akan mendengarkan pada `127.0.0.1:8080`. Pastikan variabel `.env` Anda sudah sinkron:
```env
BROADCAST_CONNECTION=reverb
QUEUE_CONNECTION=sync # atau database di production

REVERB_APP_ID=...
REVERB_APP_KEY=...
REVERB_APP_SECRET=...
REVERB_HOST="127.0.0.1"
REVERB_PORT=8080
REVERB_SCHEME=http

VITE_REVERB_APP_KEY="${REVERB_APP_KEY}"
VITE_REVERB_HOST="${REVERB_HOST}"
VITE_REVERB_PORT="${REVERB_PORT}"
VITE_REVERB_SCHEME="${REVERB_SCHEME}"
```
