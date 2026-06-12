@extends('layouts.app')

@section('title', 'Tentang TPL SV IPB')



@section('hero')
@include('partials.hero')
@endsection

@section('content')
<main class="tentang-section py-5">

    {{-- ======================== VIDEO PROFIL ======================== --}}
    <div class="container mb-5 fade-in-up">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="ratio ratio-16x9 premium-shadow" style="border-radius: 16px; overflow: hidden; border: 1px solid rgba(255, 255, 255, 0.2);">
                    <video controls autoplay muted loop style="width: 100%; height: 100%; object-fit: cover;">
                        
                        @if (!empty($profil->video))
                            <source src="{{ asset('storage/' . $profil->video) }}" type="video/mp4">
                        @else
                            <source src="{{ asset('videos/TEKNOLOGI REKAYASA PERANGKAT LUNAK - Video Profil 2025 (1).mp4') }}" type="video/mp4">
                        @endif

                        Browser Anda tidak mendukung tag video.
                    </video>
                </div>
            </div>
        </div>
    </div>

    {{-- ======================== VISI, MISI, CAPAIAN ======================== --}}
    <div class="container py-3">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                {{-- VISI --}}
                <div class="info-box premium-card fade-in-up">
                    <div class="info-box-header">
                        <h3>Visi</h3>
                    </div>
                    <div class="info-box-body">
                        <p>{{ $profil->visi ?? 'Belum ada data visi.' }}</p>
                    </div>
                </div>

                {{-- MISI --}}
                <div class="info-box premium-card fade-in-up">
                    <div class="info-box-header">
                        <h3>Misi</h3>
                    </div>
                    <div class="info-box-body">
                        {!! nl2br(e($profil->misi ?? 'Belum ada data misi.')) !!}
                    </div>
                </div>

                {{-- CAPAIAN --}}
                <div class="info-box premium-card fade-in-up">
                    <div class="info-box-header">
                        <h3>Capaian</h3>
                    </div>
                    <div class="info-box-body">
                        {!! nl2br(e($profil->capaian ?? 'Belum ada data capaian.')) !!}
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- ======================== FASILITAS & KEUNGGULAN ======================== --}}
    <div class="container py-5 mt-4">
        <header class="info-header mb-5 fade-in-up">
            <h2>Fasilitas & Ekosistem Pembelajaran</h2>
            <hr>
            <p class="text-muted text-center" style="max-width: 600px; margin: 0 auto;">Program Studi TRPL dilengkapi dengan lingkungan akademis yang sangat berorientasi pada praktik dan standar industri teknologi terkini.</p>
        </header>

        <div class="row g-4">
            {{-- Laboratorium --}}
            <div class="col-md-4 fade-in-up" style="animation-delay: 0.1s;">
                <div class="premium-card h-100 text-center p-4">
                    <div class="icon-wrapper mb-3" style="width: 70px; height: 70px; margin: 0 auto; background: rgba(79, 70, 229, 0.1); color: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-pc-display" style="font-size: 30px;"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Laboratorium Komputer</h4>
                    <p class="text-muted" style="font-size: 0.95rem;">Tersedia laboratorium dengan perangkat modern yang mumpuni untuk pengembangan web, mobile, serta analisis data besar. Praktikum dijamin lancar.</p>
                </div>
            </div>

            {{-- Dosen Praktisi --}}
            <div class="col-md-4 fade-in-up" style="animation-delay: 0.2s;">
                <div class="premium-card h-100 text-center p-4">
                    <div class="icon-wrapper mb-3" style="width: 70px; height: 70px; margin: 0 auto; background: rgba(16, 185, 129, 0.1); color: #10B981; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-people" style="font-size: 30px;"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Kolaborasi DUDI</h4>
                    <p class="text-muted" style="font-size: 0.95rem;">Pembelajaran tidak sekadar teori, namun langsung berkolaborasi dengan Dunia Usaha dan Dunia Industri (DUDI) melalui dosen praktisi berpengalaman.</p>
                </div>
            </div>

            {{-- Ekosistem Vokasi --}}
            <div class="col-md-4 fade-in-up" style="animation-delay: 0.3s;">
                <div class="premium-card h-100 text-center p-4">
                    <div class="icon-wrapper mb-3" style="width: 70px; height: 70px; margin: 0 auto; background: rgba(245, 158, 11, 0.1); color: #F59E0B; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-building" style="font-size: 30px;"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Ekosistem Vokasi IPB</h4>
                    <p class="text-muted" style="font-size: 0.95rem;">Tergabung dalam Sekolah Vokasi IPB, mahasiswa bebas mengakses fasilitas penunjang seperti perpustakaan pusat, dan UKM untuk soft-skill.</p>
                </div>
            </div>
        </div>
    </div>

</main>
@endsection