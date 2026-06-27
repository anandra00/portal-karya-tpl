<?php

use Illuminate\Support\Facades\Route;
use Modules\Core\Http\Controllers\api\ApiController;

// ============================================
// PUBLIC REST API ROUTES (V1)
// ============================================
Route::prefix('v1')->middleware('throttle:60,1')->group(function () {
    // Auth & Token Generation (stricter rate limit to prevent brute-force)
    Route::post('/login', [ApiController::class, 'login'])
        ->middleware('throttle:5,1')
        ->name('api.v1.login');

    // Public Get Routes
    Route::get('/karyas', [ApiController::class, 'getKaryas'])->name('api.v1.karyas');
    Route::get('/karyas/{id}', [ApiController::class, 'getKaryaDetail'])->name('api.v1.karya.detail');
    Route::get('/dosens', [ApiController::class, 'getDosens'])->name('api.v1.dosens');

    // Protected Write Routes (Sanctum Auth)
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/karyas', [ApiController::class, 'storeKarya'])->name('api.v1.karyas.store');
        Route::post('/karyas/{id}/reviews', [ApiController::class, 'storeReview'])->name('api.v1.reviews.store');
    });
});
