@extends('layouts.app')

@section('title', 'Karya Mahasiswa')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/karya.css') }}">
@endpush

@section('hero')
@include('partials.hero')
@endsection

@section('content')
<section class="info-section py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <header class="info-header mb-5 text-center">
                    <h2 class="fw-bold" style="color: var(--warna-hero);">Kumpulan Karya Mahasiswa TPL SV IPB</h2>
                    <hr>
                </header>
            
                {{-- Search Bar --}}
                <div class="row justify-content-center mb-4 fade-in-up">
                    <div class="col-md-8 col-lg-6">
                        <form action="{{ route('karya.public') }}" method="GET">
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-search"></i></span>
                                <input type="text" 
                                       class="form-control" 
                                       name="judul" 
                                       placeholder="Cari karya..." 
                                       value="{{ request('judul') }}">
                                <button class="btn btn-tpl" type="submit">Cari</button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Filter Kategori --}}
                <div class="row justify-content-center mb-4 fade-in-up">
                    <div class="col-md-10 text-center filter-buttons">
                        <a href="{{ route('karya.public') }}" 
                           class="btn btn-sm {{ !request('kategori') ? 'btn-tpl' : 'btn-outline-primary' }} mb-2">
                            Semua
                        </a>
                        @foreach(['Web Development', 'Mobile Apps', 'Data Science', 'IoT', 'Game Development'] as $kat)
                        <a href="{{ route('karya.public', ['kategori' => $kat]) }}" 
                           class="btn btn-sm {{ request('kategori') == $kat ? 'btn-tpl' : 'btn-outline-primary' }} mb-2">
                            {{ $kat }}
                        </a>
                        @endforeach
                    </div>
                </div>
                    
                {{-- Grid Karya --}}
                <div class="row">
                    @forelse ($karya as $k)
                        <div class="col-12 col-md-6 col-lg-4 mb-4 fade-in-up">
                            <div class="card premium-card h-100 border-0">
                                @if($k->preview_karya)
                                    <img src="{{ asset('storage/' . $k->preview_karya) }}" 
                                         class="card-img-top" 
                                         alt="{{ $k->judul }}"
                                         style="height: 250px; object-fit: cover;">
                                @else
                                    <div class="karya-placeholder">
                                        {{ $k->judul }}
                                    </div>
                                @endif
                                
                                <div class="card-body d-flex flex-column">
                                    <span class="badge text-white mb-2" style="background-color: var(--warna-utama); align-self: flex-start;">
                                        {{ $k->kategori }}
                                    </span>
                                    <h5 class="card-title">{{ Str::limit($k->judul, 50) }}</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">Oleh: {{ $k->tim_pembuat }}</h6>
                                    
                                    <div class="text-warning mb-2">
                                        @php
                                            $avgRating = $k->reviews->avg('rating') ?? 0;
                                            $reviewCount = $k->reviews->count();
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
                                    
                                    <a href="{{ route('karya.public.show', $k->id) }}" 
                                       class="btn btn-tpl btn-sm mt-auto">
                                        Selengkapnya
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center">
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle"></i> Tidak ada karya yang ditemukan.
                            </div>
                        </div>
                    @endforelse
                </div>

                {{-- Tombol Kembali --}}
                <div class="text-center mt-4 mb-4">
                    <a href="{{ route('home') }}" class="btn btn-secondary btn-lg">
                        <i class="bi bi-arrow-left me-2"></i>Kembali ke Home
                    </a>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection