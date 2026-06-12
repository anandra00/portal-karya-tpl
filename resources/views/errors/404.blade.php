@extends('layouts.app')

@section('title', 'Halaman Tidak Ditemukan - TRPL SV IPB')

@section('content')
<div class="container my-5 text-center fade-in-up" style="padding-top: 100px; padding-bottom: 100px;">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <h1 class="display-1 fw-bold" style="color: var(--warna-utama); text-shadow: 2px 2px 10px rgba(79, 70, 229, 0.2);">404</h1>
            <h2 class="mb-4 fw-bold">Oops! Halaman Tidak Ditemukan</h2>
            <p class="lead text-muted mb-5">
                Sepertinya Anda tersesat. Halaman yang Anda cari mungkin telah dihapus, diubah namanya, atau memang tidak pernah ada.
            </p>
            <a href="{{ route('home') }}" class="btn btn-tpl btn-lg px-5 py-3 rounded-pill shadow-sm">
                <i class="bi bi-house-door-fill me-2"></i> Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
@endsection
