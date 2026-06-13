<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

use App\Models\Dosen;
use App\Models\Karya;
use App\Models\User;

use App\Mail\SendEmail;

use Modules\Auth\Http\Controllers\AuthController;
use Modules\Core\Http\Controllers\HomeController;
use Modules\Core\Http\Controllers\ProfileController;
use Modules\Akademik\Http\Controllers\BeritaUserController;

use Modules\Akademik\Http\Controllers\admin\DosenController;
use Modules\Akademik\Http\Controllers\admin\MataKuliahController;
use Modules\Akademik\Http\Controllers\admin\BeritaController;
use Modules\Core\Http\Controllers\admin\ProfilProdiController;
use Modules\Core\Http\Controllers\admin\DashboardController;
use Modules\Karya\Http\Controllers\admin\ReviewController;
use Modules\Core\Http\Controllers\admin\AdminController;
use Modules\Karya\Http\Controllers\admin\KaryaController;
use Modules\Core\Http\Controllers\admin\KontakController;

// ============================================
// PUBLIC ROUTES (No Auth Required)
// ============================================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/tentang', [ProfilProdiController::class, 'showUser'])->name('tentang');
Route::get('/dosen', [HomeController::class, 'dosen'])->name('homepage.dosen'); 
Route::get('/matakuliah', [MataKuliahController::class, 'indexUser'])->name('matakuliah.user');
Route::get('/faq', [HomeController::class, 'faq'])->name('faq');

// Berita & Karya (Public)
Route::get('/berita', [BeritaUserController::class, 'index'])->name('berita.user');
Route::get('/berita/{id}', [BeritaUserController::class, 'show'])->name('berita.show');

Route::get('/karya', [KaryaController::class, 'karyaUser'])->name('karya.public');
Route::get('/karya/{id}', [KaryaController::class, 'userShow'])->name('karya.public.show');

// ============================================
// AUTH ROUTES (Login/Register/Password)
// ============================================
Route::get('/register', function () { return view('auth.register'); })->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

Route::get('/login', function () { return view('auth.login'); })->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/forgot-password', function () { return view('auth.forgot-password'); })->name('forgot-password');
Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot-password.submit');
Route::get('/reset-password/{token}', [AuthController::class, 'resetPassword'])->name('reset-password');
Route::post('/reset-password/{token}', [AuthController::class, 'submitResetPassword'])->name('reset-password.submit');

require __DIR__.'/auth.php';

// ============================================
// AUTHENTICATED USER ROUTES (Users & Admin)
// ============================================
Route::middleware(['auth'])->group(function () {
    // User Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Unggah Karya (User)
    Route::get('/unggah-karya', function () { return view('pages.unggah'); })->name('unggah');
    // Route::post('karya', [KaryaController::class, 'store'])->name('karya.store');
    
    // Rating & Review (User)
    Route::post('/review', [ReviewController::class, 'store'])->name('review.store');
});

// ============================================
// ADMIN ROUTES (Butuh role:admin)
// ============================================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    
    // Dashboard Admin
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Mail Testing (Admin only)
    Route::get('/mail/send', function () {
        $data = [
            'subject' => 'Testing Kirim Email',
            'title' => 'Testing Kirim Email',
            'body' => 'Ini adalah email uji coba dari Portal Prodi TPL.'
        ];
        Mail::to('email_tujuan@gmail.com')->send(new SendEmail($data));
        return 'Email berhasil dikirim!';
    });

    // ----------------------------------------
    // Rute yang membutuhkan prefix admin. di namanya (admin.berita.*, admin.matakuliah.*)
    // ----------------------------------------
    Route::name('admin.')->group(function () {
        Route::resource('berita', BeritaController::class);
        Route::resource('matakuliah', MataKuliahController::class);
        
        // Perbaikan celah keamanan Review (sudah dipindah ke dalam grup admin)
        Route::get('review', [ReviewController::class, 'index'])->name('review.index');
        Route::get('review/{id}', [ReviewController::class, 'show'])->name('review.show');
        Route::get('review/{id}/edit', [ReviewController::class, 'edit'])->name('review.edit');
        Route::put('review/{id}', [ReviewController::class, 'update'])->name('review.update');
        Route::delete('review/{id}', [ReviewController::class, 'destroy'])->name('review.destroy');
    });

    // ----------------------------------------
    // Rute Admin Lainnya (Namanya tidak memakai prefix admin.)
    // ----------------------------------------
    
    // Karya Management
    Route::get('karya/validasi', [KaryaController::class, 'validation'])->name("karya.validasi");
    Route::get('karya/export', [KaryaController::class, 'exportCsv'])->name('karya.export');
    Route::get('karya/validasi/{id}', [KaryaController::class, 'validationForm'])->name("karya.form");
    Route::resource('karya', KaryaController::class);

    // Admin - Activity Log
    Route::get('/activity-logs', [\Modules\Core\Http\Controllers\admin\ActivityController::class, 'index'])->name('activity-logs.index');

    // Admin - Info Prodi
    Route::resource('info-prodi', ProfilProdiController::class);
    Route::get('/info-prodi/{kodeProdi}/edit/{type}', [ProfilProdiController::class, 'editWithType'])->name('info-prodi.editType');

    // Dosen Management
    Route::get('dosen', [DosenController::class, 'index'])->name('dosen.index');
    Route::get('dosen/create', function () { return view('admin.dosen.create'); })->name('dosen.create');
    Route::post('dosen', [DosenController::class, 'store'])->name('dosen.store');
    Route::get('dosen/{id}', [DosenController::class, 'show'])->name('dosen.show');
    Route::get('dosen/{id}/edit', [DosenController::class, 'edit'])->name('dosen.edit');
    Route::put('dosen/{id}', [DosenController::class, 'update'])->name('dosen.update');
    Route::delete('dosen/{id}', [DosenController::class, 'destroy'])->name('dosen.destroy');

    // Ajuan Karya & Lihat Karya Pages
    Route::get('ajuankarya', [KaryaController::class, 'ajuanKarya'])->name('ajuankarya');

    Route::get('lihatkarya', [KaryaController::class, 'lihatKarya'])->name('lihatkarya');
    

    // Pengunjung Management
    Route::get('lihat-pengunjung', [AdminController::class, 'lihatPengunjung'])->name('lihatpengunjung');
    Route::get('export-pengunjung', [AdminController::class, 'exportPengunjung'])->name('pengunjung.export');

    // Admin List & Management
    Route::get('/list', [AdminController::class, 'index'])->name('admin.list');
    Route::get('/backup-database', [DashboardController::class, 'backupDatabase'])->name('admin.backup');
    Route::get('/create', [AdminController::class, 'create'])->name('admin.create');
    Route::post('/store', [AdminController::class, 'store'])->name('admin.store');
    Route::delete('/delete/{id}', [AdminController::class, 'destroy'])->name('admin.delete');
});
