@extends('layouts.app')

@section('title', 'Tentang TPL SV IPB')



@section('hero')
@include('partials.hero')
@endsection

@section('content')
<main class="py-20 bg-gray-50 dark:bg-gray-900 transition-colors duration-300">

    {{-- ======================== SAMBUTAN / PROFIL SINGKAT ======================== --}}
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 mb-20 fade-in-up">
        <div class="bg-gradient-to-br from-indigo-900 via-indigo-800 to-blue-900 rounded-3xl shadow-2xl overflow-hidden relative">
            <!-- Decorative circles -->
            <div class="absolute top-0 right-0 -mt-20 -mr-20 w-80 h-80 bg-white opacity-5 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 -mb-20 -ml-20 w-72 h-72 bg-blue-400 opacity-10 rounded-full blur-2xl"></div>
            
            <div class="p-10 md:p-14 relative z-10 flex flex-col md:flex-row items-center gap-10">
                <div class="w-full md:w-1/3 flex justify-center">
                    <div class="w-48 h-48 bg-white/10 backdrop-blur-md rounded-full flex items-center justify-center border border-white/20 shadow-[0_0_40px_rgba(255,255,255,0.1)] hover:scale-105 transition-transform duration-300">
                        <i class="bi bi-laptop text-7xl text-white"></i>
                    </div>
                </div>
                <div class="w-full md:w-2/3 text-center md:text-left">
                    <h2 class="text-3xl md:text-4xl font-extrabold text-white mb-4 leading-tight">Mencetak Talenta Digital Masa Depan</h2>
                    <p class="text-indigo-100 text-lg leading-relaxed mb-6">
                        Program Studi Teknologi Rekayasa Perangkat Lunak (TRPL) Sekolah Vokasi IPB didedikasikan untuk menghasilkan lulusan yang tidak hanya menguasai teori, tetapi sangat mahir dalam praktik pengembangan perangkat lunak sesuai standar industri terkemuka.
                    </p>
                    <div class="inline-flex items-center gap-2 text-white font-medium bg-white/10 px-5 py-2.5 rounded-full backdrop-blur-sm border border-white/10 shadow-sm">
                        <i class="bi bi-check-circle-fill text-green-400"></i> Terakreditasi Unggul
                    </div>
                </div>
            </div>
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
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8 pb-20">
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