@extends('layouts.app')

@section('title', 'Terjadi Kesalahan Server - TRPL SV IPB')

@section('content')
<div class="container my-5 text-center fade-in-up" style="padding-top: 100px; padding-bottom: 100px;">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <h1 class="display-1 fw-bold text-danger" style="text-shadow: 2px 2px 10px rgba(220, 53, 69, 0.2);">500</h1>
            <h2 class="mb-4 fw-bold">Waduh! Terjadi Kesalahan Server</h2>
            <p class="lead text-muted mb-5">
                Mohon maaf, server kami sedang mengalami sedikit gangguan. Tim kami sedang bekerja untuk memperbaikinya. Silakan coba lagi beberapa saat.
            </p>
            <button onclick="window.location.reload()" class="btn btn-outline-danger btn-lg px-4 py-3 rounded-pill shadow-sm me-3 mb-2">
                <i class="bi bi-arrow-clockwise me-2"></i> Muat Ulang Halaman
            </button>
            <a href="{{ route('home') }}" class="btn btn-tpl btn-lg px-4 py-3 rounded-pill shadow-sm mb-2">
                <i class="bi bi-house-door-fill me-2"></i> Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
@endsection
