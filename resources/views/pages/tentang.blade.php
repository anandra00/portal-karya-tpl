@extends('layouts.app')

@section('title', 'Tentang TPL SV IPB')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/tentang.css') }}">
@endpush

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

</main>
@endsection