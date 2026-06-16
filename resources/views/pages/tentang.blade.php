@extends('layouts.app')

@section('title', 'Tentang TPL Sekolah Vokasi IPB University')



@section('hero')
@include('partials.hero', [
    'title' => 'Tentang Program Studi',
    'subtitle' => 'Teknologi Rekayasa Perangkat Lunak Sekolah Vokasi IPB University'
])
@endsection

@section('content')
<main class="py-20 bg-gray-50 dark:bg-gray-900 transition-colors duration-300">

    {{-- ======================== SAMBUTAN / PROFIL SINGKAT ======================== --}}
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 mb-20 fade-in-up">
        <div class="bg-gradient-to-br from-indigo-900 via-indigo-800 to-blue-900 rounded-3xl shadow-2xl overflow-hidden relative">
            <!-- Decorative circles -->
            <div class="absolute top-0 right-0 -mt-20 -mr-20 w-80 h-80 bg-white opacity-5 rounded-full blur-3xl animate-blob"></div>
            <div class="absolute bottom-0 left-0 -mb-20 -ml-20 w-72 h-72 bg-blue-400 opacity-10 rounded-full blur-2xl animate-blob animation-delay-2000"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-gradient-to-r from-indigo-500/5 to-purple-500/5 rounded-full blur-3xl animate-pulse"></div>
            
            <div class="p-10 md:p-14 relative z-10 flex flex-col md:flex-row items-center gap-10">
                <div class="w-full md:w-1/3 flex justify-center">
                    <div class="w-48 h-48 bg-white/10 backdrop-blur-md rounded-full flex items-center justify-center border border-white/20 shadow-[0_0_40px_rgba(255,255,255,0.1)] hover:scale-105 transition-transform duration-300 animate-float-slow">
                        <i class="bi bi-laptop text-7xl text-white"></i>
                    </div>
                </div>
                <div class="w-full md:w-2/3 text-center md:text-left">
                    <h2 class="text-3xl md:text-4xl font-extrabold text-white mb-4 leading-tight">Mencetak Talenta Digital Masa Depan</h2>
                    <p class="text-indigo-100 text-lg leading-relaxed mb-6">
                        Program Studi Teknologi Rekayasa Perangkat Lunak (TRPL) Sekolah Vokasi IPB didedikasikan untuk menghasilkan lulusan yang tidak hanya menguasai teori, tetapi sangat mahir dalam praktik pengembangan perangkat lunak sesuai standar industri terkemuka.
                    </p>
                    <div class="inline-flex items-center gap-2 text-white font-medium bg-white/10 px-5 py-2.5 rounded-full backdrop-blur-sm border border-white/10 shadow-sm shimmer">
                        <i class="bi bi-check-circle-fill text-green-400"></i> Terakreditasi Unggul
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ======================== VISI, MISI, CAPAIAN — Tab Style ======================== --}}
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 mb-20" x-data="{ activeTab: 'visi' }">
        <div class="text-center mb-10 fade-in-up">
            <span class="inline-flex items-center gap-2 text-xs font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-widest bg-indigo-50 dark:bg-indigo-950/40 px-4 py-1.5 rounded-full border border-indigo-100 dark:border-indigo-900/30 mb-4">
                <i class="bi bi-stars"></i>
                Identitas Prodi
            </span>
            <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">Visi, Misi & Capaian</h2>
            <div class="w-16 h-1 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-full mx-auto mt-4"></div>
        </div>

        {{-- Tab Navigation --}}
        <div class="flex justify-center gap-2 mb-8 fade-in-up">
            @foreach(['visi' => 'Visi', 'misi' => 'Misi', 'capaian' => 'Capaian'] as $key => $label)
            <button @click="activeTab = '{{ $key }}'" 
                    :class="activeTab === '{{ $key }}' ? 'bg-gradient-to-r from-indigo-600 to-indigo-700 text-white shadow-lg shadow-indigo-600/20' : 'bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-400 border border-gray-200 dark:border-gray-700 hover:border-indigo-400 hover:text-indigo-600 dark:hover:text-indigo-400'"
                    class="px-6 py-2.5 rounded-xl text-sm font-bold transition-all duration-300 transform hover:scale-105 active:scale-95">
                {{ $label }}
            </button>
            @endforeach
        </div>

        {{-- Tab Content --}}
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden fade-in-up glow-ring">
            <div class="p-8 md:p-10" x-show="activeTab === 'visi'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-indigo-100 dark:bg-indigo-900/40 rounded-xl flex items-center justify-center text-indigo-600 dark:text-indigo-400">
                        <i class="bi bi-eye-fill text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Visi Program Studi</h3>
                </div>
                <p class="text-lg text-gray-700 dark:text-gray-300 leading-relaxed font-medium">{{ $profil->visi ?? 'Belum ada data visi.' }}</p>
            </div>
            <div class="p-8 md:p-10" x-show="activeTab === 'misi'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-cloak>
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-emerald-100 dark:bg-emerald-900/40 rounded-xl flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                        <i class="bi bi-flag-fill text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Misi Program Studi</h3>
                </div>
                <div class="prose prose-lg dark:prose-invert max-w-none text-gray-700 dark:text-gray-300">
                    {!! nl2br(e($profil->misi ?? 'Belum ada data misi.')) !!}
                </div>
            </div>
            <div class="p-8 md:p-10" x-show="activeTab === 'capaian'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-cloak>
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-amber-100 dark:bg-amber-900/40 rounded-xl flex items-center justify-center text-amber-600 dark:text-amber-400">
                        <i class="bi bi-trophy-fill text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Capaian Program Studi</h3>
                </div>
                <div class="prose prose-lg dark:prose-invert max-w-none text-gray-700 dark:text-gray-300">
                    {!! nl2br(e($profil->capaian ?? 'Belum ada data capaian.')) !!}
                </div>
            </div>
        </div>
    </div>

    {{-- ======================== FASILITAS & KEUNGGULAN ======================== --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8 pb-20">
        <div class="text-center mb-16 fade-in-up">
            <span class="inline-flex items-center gap-2 text-xs font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-widest bg-indigo-50 dark:bg-indigo-950/40 px-4 py-1.5 rounded-full border border-indigo-100 dark:border-indigo-900/30 mb-4">
                <i class="bi bi-building-gear"></i>
                Infrastruktur
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 dark:text-white tracking-tight mb-4">Fasilitas & Ekosistem Pembelajaran</h2>
            <div class="w-24 h-1.5 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-full mx-auto mb-6"></div>
            <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">Program Studi TRPL dilengkapi dengan lingkungan akademis yang sangat berorientasi pada praktik dan standar industri teknologi terkini.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @php
                $facilities = [
                    ['icon' => 'bi-pc-display', 'title' => 'Laboratorium Komputer', 'desc' => 'Tersedia laboratorium dengan perangkat modern yang mumpuni untuk pengembangan web, mobile, serta analisis data besar. Praktikum dijamin lancar.', 'color' => 'indigo', 'gradient' => 'from-indigo-500 to-blue-500'],
                    ['icon' => 'bi-people', 'title' => 'Kolaborasi DUDI', 'desc' => 'Pembelajaran tidak sekadar teori, namun langsung berkolaborasi dengan Dunia Usaha dan Dunia Industri (DUDI) melalui dosen praktisi berpengalaman.', 'color' => 'emerald', 'gradient' => 'from-emerald-500 to-teal-500'],
                    ['icon' => 'bi-building', 'title' => 'Ekosistem Vokasi IPB', 'desc' => 'Tergabung dalam Sekolah Vokasi IPB, mahasiswa bebas mengakses fasilitas penunjang seperti perpustakaan pusat, dan UKM untuk soft-skill.', 'color' => 'amber', 'gradient' => 'from-amber-500 to-orange-500'],
                ];
            @endphp

            @foreach ($facilities as $f)
            <div class="group bg-white dark:bg-gray-800 rounded-2xl p-8 text-center shadow-sm hover:shadow-xl transition-all duration-500 border border-gray-100 dark:border-gray-700 fade-in-up relative overflow-hidden glow-ring">
                <div class="absolute -right-8 -top-8 w-32 h-32 bg-gradient-to-br {{ $f['gradient'] }} rounded-full opacity-[0.06] group-hover:opacity-[0.12] group-hover:scale-125 transition-all duration-500"></div>
                <div class="w-16 h-16 mx-auto bg-{{ $f['color'] }}-100 dark:bg-{{ $f['color'] }}-900/30 text-{{ $f['color'] }}-600 dark:text-{{ $f['color'] }}-400 rounded-2xl flex items-center justify-center mb-6 relative z-10 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                    <i class="bi {{ $f['icon'] }} text-3xl"></i>
                </div>
                <h4 class="text-xl font-bold text-gray-900 dark:text-white mb-4 relative z-10 group-hover:text-{{ $f['color'] }}-600 dark:group-hover:text-{{ $f['color'] }}-400 transition-colors">{{ $f['title'] }}</h4>
                <p class="text-gray-600 dark:text-gray-400 leading-relaxed relative z-10">{{ $f['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>

    {{-- ======================== TIM PENGEMBANG PORTAL ======================== --}}
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 mt-20 pt-10 border-t border-gray-200 dark:border-gray-800">
        <div class="text-center mb-12 fade-in-up">
            <span class="inline-flex items-center gap-2 text-xs font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-widest bg-indigo-50 dark:bg-indigo-950/40 px-4 py-1.5 rounded-full border border-indigo-100 dark:border-indigo-900/30 mb-4">
                <i class="bi bi-code-slash"></i>
                Pengembang
            </span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight mb-3">Tim Pengembang Portal</h2>
            <div class="w-16 h-1 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-full mx-auto mb-4"></div>
            <p class="text-gray-600 dark:text-gray-400">Di balik terciptanya Portal Karya terintegrasi ini.</p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 p-8 md:p-10 hover:shadow-xl transition-all duration-300 flex flex-col md:flex-row items-center gap-8 fade-in-up glow-ring relative overflow-hidden">
            {{-- Decorative --}}
            <div class="absolute -right-16 -bottom-16 w-48 h-48 bg-gradient-to-tl from-indigo-100 dark:from-indigo-950/20 to-transparent rounded-full opacity-50"></div>

            <div class="w-full md:w-1/3 flex justify-center relative z-10">
                <div class="relative group bg-gray-200 dark:bg-gray-700 rounded-full" :class="loaded ? '' : 'animate-pulse'" x-data="{ loaded: false }" x-init="if ($refs.img && $refs.img.complete) loaded = true">
                    {{-- Gradient ring --}}
                    <div class="absolute -inset-1.5 bg-gradient-to-tr from-indigo-600 via-purple-500 to-pink-500 rounded-full opacity-30 group-hover:opacity-70 transition-opacity duration-300 blur-sm animate-spin-slow"></div>
                    <div class="absolute -inset-1 bg-gradient-to-tr from-indigo-600 via-purple-500 to-pink-500 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <img x-ref="img" src="https://github.com/anandra00.png" alt="Anandra Dandi Anugrah" 
                         class="relative w-40 h-40 rounded-full object-cover border-4 border-white dark:border-gray-700 shadow-lg group-hover:scale-105 transition-all duration-300" 
                         loading="lazy"
                         @load="loaded = true"
                         :class="loaded ? 'opacity-100' : 'opacity-0'"
                         onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name=Anandra+Dandi+Anugrah&background=4f46e5&color=fff&size=180';">
                </div>
            </div>
            <div class="w-full md:w-2/3 text-center md:text-left relative z-10">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 mb-3 border border-indigo-100 dark:border-indigo-800">
                    Lead Full-Stack Developer
                </span>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Anandra Dandi Anugrah</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4 font-medium">Mahasiswa Teknologi Rekayasa Perangkat Lunak SV IPB</p>
                <p class="text-gray-600 dark:text-gray-300 leading-relaxed mb-6">
                    Merancang dan mengembangkan Portal Karya ini dengan arsitektur Modular Monolith, mengoptimalkan database, menyelaraskan mode gelap premium, serta membangun REST API publik untuk menyediakan integrasi yang andal dan aman bagi program studi.
                </p>
                
                {{-- Badges Keahlian --}}
                <div class="flex flex-wrap gap-2 mb-6 justify-center md:justify-start">
                    @foreach(['Laravel 11', 'PHP 8.2+', 'Tailwind CSS', 'Alpine.js', 'MySQL'] as $skill)
                    <span class="px-3 py-1 text-xs font-semibold bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-indigo-50 dark:hover:bg-indigo-900/30 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors cursor-default">{{ $skill }}</span>
                    @endforeach
                </div>

                {{-- Jejaring Sosial --}}
                <div class="flex gap-3 justify-center md:justify-start">
                    <a href="https://github.com/anandra00" target="_blank" class="w-10 h-10 rounded-xl bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-500 hover:bg-gray-900 hover:text-white dark:hover:bg-white dark:hover:text-gray-900 transition-all duration-300 hover:scale-110">
                        <i class="bi bi-github text-lg"></i>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-xl bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-500 hover:bg-blue-600 hover:text-white transition-all duration-300 hover:scale-110">
                        <i class="bi bi-linkedin text-lg"></i>
                    </a>
                    <a href="mailto:anandra00@apps.ipb.ac.id" class="w-10 h-10 rounded-xl bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-500 hover:bg-red-500 hover:text-white transition-all duration-300 hover:scale-110">
                        <i class="bi bi-envelope text-lg"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

</main>
@endsection