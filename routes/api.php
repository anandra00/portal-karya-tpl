<?php

use Illuminate\Support\Facades\Route;
use Modules\Core\Http\Controllers\api\ApiController;

// ============================================
// PUBLIC REST API ROUTES (V1)
// ============================================
Route::prefix('v1')->middleware('throttle:60,1')->group(function () {
    Route::get('/karyas', [ApiController::class, 'getKaryas'])->name('api.v1.karyas');
    Route::get('/karyas/{id}', [ApiController::class, 'getKaryaDetail'])->name('api.v1.karya.detail');
    Route::get('/dosens', [ApiController::class, 'getDosens'])->name('api.v1.dosens');
});
