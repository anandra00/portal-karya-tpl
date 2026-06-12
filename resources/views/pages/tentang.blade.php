@extends('layouts.app')

@section('title', 'Tentang TPL SV IPB')



@section('hero')
@include('partials.hero')
@endsection

@section('content')
<main class="py-20 bg-gray-50 dark:bg-gray-900 transition-colors duration-300">

    {{-- ======================== VIDEO PROFIL ======================== --}}
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 mb-20 fade-in-up">
        <div class="aspect-w-16 aspect-h-9 shadow-2xl rounded-2xl overflow-hidden border border-gray-200 dark:border-gray-800">
            <video controls autoplay muted loop class="w-full h-full object-cover">
                @if (!empty($profil->video))
                    <source src="{{ asset('storage/' . $profil->video) }}" type="video/mp4">
                @else
                    <source src="{{ asset('videos/TEKNOLOGI REKAYASA PERANGKAT LUNAK - Video Profil 2025 (1).mp4') }}" type="video/mp4">
                @endif
                Browser Anda tidak mendukung tag video.
            </video>
        </div>
    </div>

    {{-- ======================== VISI, MISI, CAPAIAN ======================== --}}
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 mb-20">
        <div class="space-y-8">

            {{-- VISI --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden fade-in-up">
                <div class="bg-indigo-600 dark:bg-indigo-900 px-6 py-4">
                    <h3 class="text-xl font-bold text-white mb-0">Visi</h3>
                </div>
                <div class="p-6 md:p-8">
                    <p class="text-lg text-gray-700 dark:text-gray-300 leading-relaxed font-medium">{{ $profil->visi ?? 'Belum ada data visi.' }}</p>
                </div>
            </div>

            {{-- MISI --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden fade-in-up">
                <div class="bg-indigo-600 dark:bg-indigo-900 px-6 py-4">
                    <h3 class="text-xl font-bold text-white mb-0">Misi</h3>
                </div>
                <div class="p-6 md:p-8">
                    <div class="prose prose-lg dark:prose-invert max-w-none text-gray-700 dark:text-gray-300">
                        {!! nl2br(e($profil->misi ?? 'Belum ada data misi.')) !!}
                    </div>
                </div>
            </div>

            {{-- CAPAIAN --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden fade-in-up">
                <div class="bg-indigo-600 dark:bg-indigo-900 px-6 py-4">
                    <h3 class="text-xl font-bold text-white mb-0">Capaian</h3>
                </div>
                <div class="p-6 md:p-8">
                    <div class="prose prose-lg dark:prose-invert max-w-none text-gray-700 dark:text-gray-300">
                        {!! nl2br(e($profil->capaian ?? 'Belum ada data capaian.')) !!}
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- ======================== FASILITAS & KEUNGGULAN ======================== --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
        <div class="text-center mb-16 fade-in-up">
            <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 dark:text-white tracking-tight mb-4">Fasilitas & Ekosistem Pembelajaran</h2>
            <div class="w-24 h-1.5 bg-gradient-to-r from-indigo-600 to-indigo-400 rounded-full mx-auto mb-6"></div>
            <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">Program Studi TRPL dilengkapi dengan lingkungan akademis yang sangat berorientasi pada praktik dan standar industri teknologi terkini.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            {{-- Laboratorium --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-8 text-center shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 dark:border-gray-700 fade-in-up" style="animation-delay: 0.1s;">
                <div class="w-20 h-20 mx-auto bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 rounded-full flex items-center justify-center mb-6">
                    <i class="bi bi-pc-display text-4xl"></i>
                </div>
                <h4 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Laboratorium Komputer</h4>
                <p class="text-gray-600 dark:text-gray-400 leading-relaxed">Tersedia laboratorium dengan perangkat modern yang mumpuni untuk pengembangan web, mobile, serta analisis data besar. Praktikum dijamin lancar.</p>
            </div>

            {{-- Dosen Praktisi --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-8 text-center shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 dark:border-gray-700 fade-in-up" style="animation-delay: 0.2s;">
                <div class="w-20 h-20 mx-auto bg-green-50 dark:bg-green-900/30 text-green-500 rounded-full flex items-center justify-center mb-6">
                    <i class="bi bi-people text-4xl"></i>
                </div>
                <h4 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Kolaborasi DUDI</h4>
                <p class="text-gray-600 dark:text-gray-400 leading-relaxed">Pembelajaran tidak sekadar teori, namun langsung berkolaborasi dengan Dunia Usaha dan Dunia Industri (DUDI) melalui dosen praktisi berpengalaman.</p>
            </div>

            {{-- Ekosistem Vokasi --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-8 text-center shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 dark:border-gray-700 fade-in-up" style="animation-delay: 0.3s;">
                <div class="w-20 h-20 mx-auto bg-yellow-50 dark:bg-yellow-900/30 text-yellow-500 rounded-full flex items-center justify-center mb-6">
                    <i class="bi bi-building text-4xl"></i>
                </div>
                <h4 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Ekosistem Vokasi IPB</h4>
                <p class="text-gray-600 dark:text-gray-400 leading-relaxed">Tergabung dalam Sekolah Vokasi IPB, mahasiswa bebas mengakses fasilitas penunjang seperti perpustakaan pusat, dan UKM untuk soft-skill.</p>
            </div>
        </div>
    </div>

</main>
@endsection