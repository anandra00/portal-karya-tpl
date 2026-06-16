@extends('layouts.app')

@section('title', 'Karya Mahasiswa')

@section('hero')
@include('partials.hero', [
    'title' => 'Galeri Karya Mahasiswa',
    'subtitle' => 'Karya Kreatif & Solutif Berbasis Teknologi Rekayasa Perangkat Lunak'
])
@endsection

@section('content')
<section class="py-20 bg-gray-50 dark:bg-gray-900 transition-colors duration-300"
         x-data="{
             searchQuery: '{{ request('search') ?? request('judul') }}',
             selectedCategory: '{{ request('kategori') ?? 'Semua' }}',
             filterKarya(judul, kategori, tim, deskripsi) {
                 let matchQuery = true;
                 let matchCategory = true;
                 
                 if (this.searchQuery) {
                     const q = this.searchQuery.toLowerCase().trim();
                     matchQuery = judul.toLowerCase().includes(q) || 
                                  tim.toLowerCase().includes(q) || 
                                  kategori.toLowerCase().includes(q) || 
                                  deskripsi.toLowerCase().includes(q);
                 }
                 
                 if (this.selectedCategory !== 'Semua') {
                     matchCategory = kategori.toLowerCase().trim() === this.selectedCategory.toLowerCase().trim();
                 }
                 
                 return matchQuery && matchCategory;
             },
             init() {
                 this.$watch('searchQuery', () => this.checkEmptyGrid());
                 this.$watch('selectedCategory', () => this.checkEmptyGrid());
                 this.checkEmptyGrid();
             },
             checkEmptyGrid() {
                 setTimeout(() => {
                     const cards = document.querySelectorAll('.karya-card');
                     let visibleCount = 0;
                     cards.forEach(card => {
                         if (card.style.display !== 'none') visibleCount++;
                     });
                     
                     const noResults = document.getElementById('no-karya-results');
                     if (noResults) {
                         noResults.style.display = visibleCount === 0 ? 'block' : 'none';
                     }
                 }, 50);
             }
         }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-14">
            <span class="inline-flex items-center gap-2 text-xs font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-widest bg-indigo-50 dark:bg-indigo-950/40 px-4 py-1.5 rounded-full border border-indigo-100 dark:border-indigo-900/30 mb-4">
                <i class="bi bi-collection"></i>
                Galeri Karya
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 dark:text-white tracking-tight">Kumpulan Karya Mahasiswa TPL<br class="hidden sm:block"/> Sekolah Vokasi IPB University</h2>
            <div class="w-24 h-1.5 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-full mx-auto mt-6"></div>
        </div>
        
        {{-- Search Bar — Glassmorphism --}}
        <div class="max-w-2xl mx-auto mb-10 fade-in-up">
            <form action="{{ route('karya.public') }}" method="GET" @submit.prevent="">
                <div class="relative flex items-center group">
                    <span class="absolute left-5 text-gray-400 dark:text-gray-500 group-focus-within:text-indigo-500 transition-colors">
                        <i class="bi bi-search text-lg"></i>
                    </span>
                    <input type="text" 
                           class="w-full pl-14 pr-28 py-4 rounded-2xl border border-gray-200/80 dark:border-gray-700 bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm focus:shadow-[0_0_30px_rgba(99,102,241,0.12)] transition-all outline-none text-base font-medium" 
                           name="search" 
                           x-model="searchQuery"
                           placeholder="Cari karya berdasarkan judul, tim, atau kategori...">
                    <button class="absolute right-2 top-2 bottom-2 px-6 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white font-semibold rounded-xl hover:from-indigo-700 hover:to-indigo-800 transition-all shadow-md hover:shadow-lg transform hover:scale-[1.02] active:scale-95" type="button" @click="searchQuery = searchQuery">
                        Cari
                    </button>
                </div>
            </form>
        </div>

        {{-- Filter Kategori — Pills --}}
        <div class="flex flex-wrap justify-center gap-3 mb-16 fade-in-up">
            <a href="#" 
               @click.prevent="selectedCategory = 'Semua'"
               :class="selectedCategory === 'Semua' ? 'bg-gradient-to-r from-indigo-600 to-indigo-700 text-white shadow-lg shadow-indigo-600/20' : 'bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-400 border border-gray-200 dark:border-gray-700 hover:border-indigo-400 hover:text-indigo-600 dark:hover:text-indigo-400'"
               class="px-5 py-2.5 rounded-xl text-sm font-semibold transition-all shadow-sm transform hover:scale-105 active:scale-95 duration-200">
                <i class="bi bi-grid-3x3-gap mr-1"></i> Semua
            </a>
            @foreach($categories as $kat)
            <a href="#" 
               @click.prevent="selectedCategory = '{{ $kat->name }}'"
               :class="selectedCategory === '{{ $kat->name }}' ? 'bg-gradient-to-r from-indigo-600 to-indigo-700 text-white shadow-lg shadow-indigo-600/20' : 'bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-400 border border-gray-200 dark:border-gray-700 hover:border-indigo-400 hover:text-indigo-600 dark:hover:text-indigo-400'"
               class="px-5 py-2.5 rounded-xl text-sm font-semibold transition-all shadow-sm transform hover:scale-105 active:scale-95 duration-200">
                {{ $kat->name }}
            </a>
            @endforeach
        </div>
            
        {{-- Grid Karya --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse ($karya as $k)
                <div class="karya-card bg-white dark:bg-gray-800 rounded-2xl shadow-sm overflow-hidden flex flex-col group border border-gray-100 dark:border-gray-700 fade-in-up"
                     x-show="filterKarya('{{ addslashes($k->judul) }}', '{{ addslashes($k->kategori) }}', '{{ addslashes($k->tim_pembuat) }}', '{{ addslashes(Str::limit(strip_tags($k->deskripsi), 200)) }}')">
                    
                    <div class="relative overflow-hidden h-64 bg-gray-100 dark:bg-gray-900 flex items-center justify-center" :class="loaded ? '' : 'animate-pulse'" x-data="{ loaded: false }" x-init="if ($refs.img && $refs.img.complete) loaded = true">
                        @if($k->preview_karya)
                            <img x-ref="img" src="{{ asset('storage/' . $k->preview_karya) }}" 
                                 class="w-full h-full object-cover transition-all duration-700 group-hover:scale-110" 
                                 loading="lazy"
                                 @load="loaded = true"
                                 :class="loaded ? 'opacity-100' : 'opacity-0'"
                                 alt="{{ $k->judul }}">
                        @else
                            <span class="text-xl font-bold text-gray-400 dark:text-gray-600" x-init="loaded = true">{{ $k->judul }}</span>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black/30 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        <div class="absolute top-4 left-4">
                            <span class="px-3 py-1.5 bg-indigo-600/90 backdrop-blur-sm text-white text-xs font-bold rounded-full shadow-lg">{{ $k->kategori }}</span>
                        </div>
                    </div>
                    
                    <div class="p-6 flex flex-col flex-grow">
                        <h5 class="text-xl font-bold text-gray-900 dark:text-white mb-2 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">{{ Str::limit($k->judul, 50) }}</h5>
                        <h6 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-4">Oleh: {{ $k->tim_pembuat }}</h6>
                        
                        <div class="flex items-center text-yellow-400 mb-6">
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
                                    <i class="bi bi-star text-gray-300 dark:text-gray-600"></i>
                                  @endif
                            @endfor
                            
                            <span class="ml-2 text-sm text-gray-500 dark:text-gray-400 font-medium">
                                {{ number_format($avgRating, 1) }} ({{ $reviewCount }})
                            </span>
                        </div>
                        
                        <div class="mt-auto">
                            <a href="{{ route('karya.public.show', $k->id) }}" 
                               class="inline-flex justify-center items-center w-full px-4 py-2.5 bg-indigo-50 dark:bg-gray-700 text-indigo-600 dark:text-indigo-300 font-semibold rounded-xl hover:bg-indigo-100 dark:hover:bg-gray-600 transition-all group/btn">
                                Selengkapnya
                                <i class="bi bi-arrow-right ml-2 group-hover/btn:translate-x-1 transition-transform"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full">
                    <div class="text-center py-16 bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700">
                        <i class="bi bi-inbox text-5xl text-gray-300 dark:text-gray-600 mb-4 block"></i>
                        <h3 class="text-lg font-bold text-gray-500 dark:text-gray-400">Belum ada karya yang ditemukan</h3>
                        <p class="text-gray-400 dark:text-gray-500 mt-2">Karya akan muncul setelah diunggah dan divalidasi.</p>
                    </div>
                </div>
            @endforelse

            {{-- Dynamic No Results Message --}}
            <div class="col-span-full" id="no-karya-results" style="display: none;">
                <div class="text-center py-16 bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700">
                    <i class="bi bi-search text-5xl text-indigo-300 dark:text-indigo-700 mb-4 block"></i>
                    <h3 class="text-lg font-bold text-gray-700 dark:text-gray-300">Tidak ada hasil ditemukan</h3>
                    <p class="text-gray-500 dark:text-gray-400 mt-2">Coba gunakan kata kunci atau filter yang berbeda.</p>
                </div>
            </div>
        </div>

        {{-- Tombol Kembali --}}
        <div class="text-center mt-14 mb-4">
            <a href="{{ route('home') }}" class="inline-flex items-center px-6 py-3 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 font-semibold rounded-xl border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition-all shadow-sm hover:shadow-md group">
                <i class="bi bi-arrow-left mr-2 group-hover:-translate-x-1 transition-transform"></i>Kembali ke Home
            </a>
        </div>

    </div>
</section>
@endsection