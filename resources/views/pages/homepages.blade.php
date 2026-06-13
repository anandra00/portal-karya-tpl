@extends('layouts.app')

@section('title', 'Halaman Utama')



{{-- BAGIAN HERO --}}
@section('hero')
@include('partials.hero')
@endsection

@section('content')

{{-- NOTIFIKASI: Hanya muncul jika session 'show_welcome' ada --}}
@if (session('show_welcome') && Auth::check())
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
    <div x-data="{ show: true }" x-show="show" class="relative bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded text-center mb-6" role="alert">
        Selamat datang, <strong>{{ Auth::user()->name }}!</strong>
        <button @click="show = false" type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3">
            <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
        </button>
    </div>
</div>
@endif

<section class="py-12 bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
    
    {{-- BAGIAN HIGHLIGHT PORTAL --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-16 fade-in-up">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-lg border border-gray-100 dark:border-gray-700 hover:-translate-y-2 transition-transform duration-300 relative overflow-hidden">
                <div class="absolute -right-6 -top-6 w-24 h-24 bg-indigo-50 dark:bg-gray-700 rounded-full opacity-50"></div>
                <div class="w-14 h-14 bg-indigo-100 dark:bg-indigo-900/50 text-indigo-600 dark:text-indigo-400 rounded-2xl flex items-center justify-center mb-6 relative z-10">
                    <i class="bi bi-rocket-takeoff text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3 relative z-10">Inovasi Berkelanjutan</h3>
                <p class="text-gray-600 dark:text-gray-400 relative z-10">Portal ini menjadi wadah utama bagi mahasiswa TRPL untuk memamerkan solusi teknologi yang relevan dengan kebutuhan industri masa kini.</p>
            </div>
            
            <div class="bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-lg border border-gray-100 dark:border-gray-700 hover:-translate-y-2 transition-transform duration-300 relative overflow-hidden">
                <div class="absolute -right-6 -top-6 w-24 h-24 bg-green-50 dark:bg-gray-700 rounded-full opacity-50"></div>
                <div class="w-14 h-14 bg-green-100 dark:bg-green-900/50 text-green-600 dark:text-green-400 rounded-2xl flex items-center justify-center mb-6 relative z-10">
                    <i class="bi bi-people text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3 relative z-10">Kolaborasi Tim</h3>
                <p class="text-gray-600 dark:text-gray-400 relative z-10">Setiap karya merupakan hasil kerja keras tim mahasiswa yang mengedepankan kolaborasi, komunikasi, dan manajemen proyek yang baik.</p>
            </div>
            
            <div class="bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-lg border border-gray-100 dark:border-gray-700 hover:-translate-y-2 transition-transform duration-300 relative overflow-hidden">
                <div class="absolute -right-6 -top-6 w-24 h-24 bg-yellow-50 dark:bg-gray-700 rounded-full opacity-50"></div>
                <div class="w-14 h-14 bg-yellow-100 dark:bg-yellow-900/50 text-yellow-600 dark:text-yellow-400 rounded-2xl flex items-center justify-center mb-6 relative z-10">
                    <i class="bi bi-star text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3 relative z-10">Standar Industri</h3>
                <p class="text-gray-600 dark:text-gray-400 relative z-10">Aplikasi yang dikembangkan berpedoman pada standar industri teknologi, mulai dari UI/UX, keamanan, hingga efisiensi sistem.</p>
            </div>
        </div>
    </div>
            
    {{-- BAGIAN KARYA MAHASISWA --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-20">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">Kumpulan Karya Mahasiswa<br/>Teknologi Rekayasa Perangkat Lunak Sekolah Vokasi IPB University</h2>
            <div class="w-24 h-1.5 bg-gradient-to-r from-indigo-600 to-indigo-400 rounded-full mx-auto mt-4"></div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($karyas as $karya)
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col group border border-gray-100 dark:border-gray-700 fade-in-up">
                <div class="relative overflow-hidden h-56">
                    <img src="{{ $karya->preview_karya ? asset('storage/' . $karya->preview_karya) : 'https://placehold.co/600x400/333/white?text=Aplikasi+1' }}" 
                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" 
                         alt="Karya Mahasiswa">
                    <div class="absolute top-4 left-4">
                        <span class="px-3 py-1 bg-indigo-600 text-white text-xs font-bold rounded-full shadow-sm">{{ $karya->kategori }}</span>
                    </div>
                </div>
                
                <div class="p-6 flex flex-col flex-grow">
                    <h5 class="text-xl font-bold text-gray-900 dark:text-white mb-1 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">{{ $karya->judul }}</h5>
                    <h6 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-4">{{ $karya->tim_pembuat }}</h6>
                    
                    <div class="flex items-center text-yellow-400 mb-6">
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
                        <span class="ml-2 text-sm text-gray-500 dark:text-gray-400 font-medium">
                            {{ number_format($avgRating, 1) }} ({{ $reviewCount }} ulasan)
                        </span>
                    </div>
                    
                    <div class="mt-auto">
                        <a href="{{ route('karya.public.show', $karya->id) }}" class="inline-flex justify-center w-full px-4 py-2 bg-indigo-50 dark:bg-gray-700 text-indigo-600 dark:text-indigo-300 font-semibold rounded-lg hover:bg-indigo-100 dark:hover:bg-gray-600 transition-colors">Selengkapnya</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-12 flex flex-col sm:flex-row items-center justify-center space-y-4 sm:space-y-0 sm:space-x-6">
            <a href="{{ route('karya.public') }}" class="w-full sm:w-auto px-8 py-4 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 shadow-md transition-all text-center">Cari Karya Lainnya</a>
            <a href="{{ route('unggah') }}" class="w-full sm:w-auto px-8 py-4 bg-white dark:bg-gray-800 text-indigo-600 dark:text-indigo-400 font-bold rounded-xl border-2 border-indigo-200 dark:border-gray-700 hover:border-indigo-600 dark:hover:border-indigo-500 hover:bg-indigo-50 dark:hover:bg-gray-700 shadow-sm transition-all text-center">Unggah Karya</a>
        </div>
    </div>
    
    {{-- BAGIAN BERITA --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-20">
        <div class="bg-white dark:bg-gray-800 rounded-3xl p-8 sm:p-12 shadow-sm border border-gray-100 dark:border-gray-700">
            <h2 class="text-3xl font-extrabold text-center text-gray-900 dark:text-white mb-10">Berita TPL Sekolah Vokasi IPB University</h2>

            <div class="max-w-4xl mx-auto space-y-6">
                @foreach ($beritas as $berita)
                <div class="bg-gray-50 dark:bg-gray-900 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300 border border-gray-100 dark:border-gray-800 fade-in-up">
                    <div class="flex flex-col sm:flex-row">
                        <div class="sm:w-1/3">
                            <a href="{{ route('berita.show', $berita->id) }}" class="block h-full">
                                <img src="{{ asset('storage/' . $berita->gambar ) }}" 
                                     class="w-full h-48 sm:h-full object-cover" 
                                     alt="{{ $berita->judul }}">
                            </a>
                        </div>

                        <div class="sm:w-2/3 p-6 sm:p-8 flex flex-col justify-center">
                            <h5 class="text-xl font-bold text-gray-900 dark:text-white mb-3 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                                <a href="{{ route('berita.show', $berita->id) }}">
                                    {{ $berita->judul }}
                                </a>
                            </h5>

                            <p class="text-gray-600 dark:text-gray-400 mb-4 line-clamp-3">
                                {{ Str::limit($berita->isi, 120) }}
                            </p>

                            <div class="flex items-center text-sm text-gray-500 dark:text-gray-500 font-medium">
                                <i class="bi bi-calendar3 mr-2"></i>
                                {{ \Carbon\Carbon::parse($berita->created_at)->translatedFormat('d F Y') }}
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- BAGIAN PMB (Penerimaan Mahasiswa Baru) --}}
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 mb-12 fade-in-up">
        <div class="relative rounded-3xl overflow-hidden bg-gradient-to-br from-indigo-900 to-indigo-600 p-10 sm:p-16 text-center text-white shadow-2xl">
            <!-- Decorative Elements -->
            <div class="absolute -top-24 -right-24 w-64 h-64 bg-white opacity-10 rounded-full blur-2xl"></div>
            <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-white opacity-10 rounded-full blur-2xl"></div>
            
            <div class="relative z-10 max-w-2xl mx-auto">
                <h2 class="text-3xl sm:text-4xl font-extrabold mb-4">Bergabunglah Bersama TRPL Sekolah Vokasi IPB University</h2>
                <p class="text-lg sm:text-xl text-indigo-100 mb-8 leading-relaxed">
                    Jadilah bagian dari generasi inovator digital. Dapatkan pendidikan vokasi terbaik di bidang rekayasa perangkat lunak dan ciptakan solusi teknologi untuk masa depan.
                </p>
                <a href="https://admisi.ipb.ac.id" target="_blank" class="inline-flex items-center justify-center px-8 py-4 bg-white text-indigo-600 font-extrabold rounded-full hover:bg-gray-50 hover:scale-105 transition-all shadow-lg text-lg">
                    Informasi Pendaftaran (PMB) <i class="bi bi-arrow-right ml-2 text-xl"></i>
                </a>
            </div>
        </div>
    </div>

</section>
@endsection