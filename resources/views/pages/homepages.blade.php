@extends('layouts.app')

@section('title', 'Halaman Utama')



{{-- BAGIAN HERO --}}
@section('hero')
@include('partials.hero')
@endsection

@section('content')

{{-- NOTIFIKASI: Hanya muncul jika session 'show_welcome' ada --}}
@if (session('show_welcome') && Auth::check())
<div class="container mt-3">
    <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
        Selamat datang, <strong>{{ Auth::user()->name }}!</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
</div>
@endif

<section class="info-section">
    
    {{-- BAGIAN VIDEO --}}
    <div class="container mt-4 mb-5 fade-in-up">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="ratio ratio-16x9 shadow-lg" style="border-radius: 15px; overflow: hidden; border: 1px solid #ddd;">
                        <iframe 
                            src="https://www.youtube.com/embed/ch03himP1XQ?si=guh3EiDAjV6s4CYJ" 
                            title="YouTube video player" 
                            frameborder="0" 
                            loading="lazy"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                            referrerpolicy="strict-origin-when-cross-origin" 
                            allowfullscreen>
                        </iframe>
                </div>
            </div>
        </div>
    </div>
            
    <div class="container">
        {{-- BAGIAN KARYA MAHASISWA --}}
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <header class="info-header">
                    <h2>Kumpulan Karya Mahasiswa Teknologi Rekayasa Perangkat Lunak SV IPB</h2>
                    <hr>
                </header>
                <div class="row">
                    @foreach ($karyas as $karya)
                    <div class="col-12 col-md-6 col-lg-4 mb-4 fade-in-up">
                        <div class="card h-100 shadow-sm border-0">
                            <img src="{{ $karya->preview_karya ? asset('storage/' . $karya->preview_karya) : 'https://placehold.co/600x400/333/white?text=Aplikasi+1' }}" 
                                 class="card-img-top" 
                                 alt="Karya Mahasiswa"
                                 style="height: 220px; object-fit: cover; width: 100%;">
                            
                            <div class="card-body d-flex flex-column">
                                <span class="badge text-white mb-2" style="background-color: var(--warna-utama); align-self: flex-start;">{{ $karya->kategori }}</span>
                                <h5 class="card-title">{{ $karya->judul }}</h5>
                                <h6 class="card-subtitle mb-2 text-muted">{{ $karya->tim_pembuat }}</h6>
                                
                                <div class="text-warning mb-2">
                                    @php
                                        $avgRating = $karya->reviews->avg('rating') ?? 0;
                                        $reviewCount = $karya->reviews->count();
                                    @endphp
                                    
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= floor($avgRating))
                                            <i class="bi bi-star-fill"></i>
                                        @elseif ($i <= ceil($avgRating) && $avgRating - floor($avgRating) >= 0.5)
                                            <i class="bi bi-star-half"></i>
                                        @else
                                            <i class="bi bi-star"></i>
                                        @endif
                                    @endfor
                                    
                                    <small class="mt-1 text-muted d-block">
                                        {{ number_format($avgRating, 1) }} ({{ $reviewCount }} ulasan)
                                    </small>
                                </div>
                                
                                <a href="{{ route('karya.public.show', $karya->id) }}" class="btn btn-tpl btn-sm mt-auto align-self-end">Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="text-center mt-3 btn-group-responsive">
                    <a href="{{ route('karya.public') }}" class="btn btn-tpl btn-lg px-4 py-3">Cari Karya Lainnya</a>
                    <a href="{{ route('unggah') }}" class="btn btn-tpl btn-lg px-4 py-3">Unggah Karya</a>
                </div>
            </div>
        </div>
    
    {{-- BAGIAN BERITA --}}
    <div class="container my-5 py-4" style="background-color: #f8f9fa; border-radius: 12px;">

        <h2 class="text-center mb-4 fw-bold" style="font-size: 32px;">
            Berita TPL SV IPB
        </h2>

        <div class="row justify-content-center">
            <div class="col-lg-10">
                @foreach ($beritas as $berita)
                <div class="card mb-4 shadow-sm text-dark border-0 fade-in-up">
                    <div class="row g-0 align-items-center">
                        <div class="col-md-4">
                            <a href="{{ route('berita.show', $berita->id) }}">
                                <img src="{{ asset('storage/' . $berita->gambar ) }}" 
                                     class="img-fluid rounded-start" 
                                     alt="{{ $berita->judul }}"
                                     style="width: 100%; height: 220px; object-fit: cover;">
                            </a>
                        </div>

                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title fw-bold">
                                    <a href="{{ route('berita.show', $berita->id) }}" class="text-decoration-none text-dark">
                                        {{ $berita->judul }}
                                    </a>
                                </h5>

                                <p class="card-text text-muted">
                                    {{ Str::limit($berita->isi, 120) }}
                                </p>

                                <p class="card-text d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        {{ \Carbon\Carbon::parse($berita->created_at)->translatedFormat('d F Y') }}
                                    </small>
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
                @endforeach
            </div>
        </div>

    </div>

    {{-- BAGIAN PMB (Penerimaan Mahasiswa Baru) --}}
    <div class="container mb-5 fade-in-up">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="premium-card p-5 text-center text-white" style="background: linear-gradient(135deg, var(--warna-hero) 0%, var(--warna-utama) 100%); border-radius: 16px; position: relative; overflow: hidden;">
                    {{-- Dekorasi background --}}
                    <div style="position: absolute; top: -50px; right: -50px; width: 150px; height: 150px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
                    <div style="position: absolute; bottom: -30px; left: -30px; width: 100px; height: 100px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
                    
                    <div style="position: relative; z-index: 2;">
                        <h2 class="fw-bold mb-3">Bergabunglah Bersama TRPL SV IPB</h2>
                        <p class="mb-4" style="font-size: 1.1rem; opacity: 0.9; max-width: 600px; margin: 0 auto;">
                            Jadilah bagian dari generasi inovator digital. Dapatkan pendidikan vokasi terbaik di bidang rekayasa perangkat lunak dan ciptakan solusi teknologi untuk masa depan.
                        </p>
                        <a href="https://admisi.ipb.ac.id" target="_blank" class="btn btn-light btn-lg fw-bold text-primary px-5 py-3" style="border-radius: 30px; box-shadow: 0 10px 20px rgba(0,0,0,0.15); transition: transform 0.3s ease;">
                            Informasi Pendaftaran (PMB) <i class="bi bi-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
@endsection