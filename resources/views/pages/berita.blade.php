@extends('layouts.app')

@section('title', 'Detail Berita')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/berita.css') }}">
@endpush

@section('hero')
@include('partials.hero')
@endsection

@section('content')
    <main class="article-section info-section py-5">
        <div class="container fade-in-up">
            <div class="row justify-content-center">
                <div class="col-lg-8 premium-card p-4 p-md-5 mt-4 mb-4">

                    <h1 class="article-title fw-bold mb-3">{{ $berita->judul }}</h1>

                    <div class="article-meta mb-4">
                        <span class="text-muted"><i class="bi bi-person-fill me-1"></i> Admin Portal</span>
                        <span class="text-muted ms-3"><i class="bi bi-calendar-event-fill me-1"></i>
                            {{ \Carbon\Carbon::parse($berita->created_at)->translatedFormat('d F Y') }}</span>
                    </div>

                    <img src="{{ asset('storage/' . $berita->gambar) }}" alt="{{ $berita->judul }}"
                        class="img-fluid rounded article-image mb-4">

                    <div class="article-content">
                        {{$berita->isi}}
                    </div>

                    <hr class="my-4">

                    <div class="share-section">
                        <strong>Bagikan Artikel:</strong>
                        <a href="#" class="ms-2 share-icon"><i class="bi bi-facebook fs-4"></i></a>
                        <a href="#" class="ms-2 share-icon"><i class="bi bi-twitter fs-4"></i></a>
                        <a href="#" class="ms-2 share-icon"><i class="bi bi-whatsapp fs-4"></i></a>
                    </div>

                    <div class="d-flex justify-content-center mt-4 mb-3">
                        <a href="{{ route('home') }}" class="btn btn-secondary px-4 py-2">
                            <i class="bi bi-arrow-left me-2"></i>Kembali ke Home
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </main>
@endsection