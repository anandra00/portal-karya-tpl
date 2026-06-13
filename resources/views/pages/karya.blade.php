@extends('layouts.app')

@section('title', 'Karya Mahasiswa')

@section('hero')
@include('partials.hero')
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
        
        <div class="text-center mb-12">
            <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 dark:text-white tracking-tight">Kumpulan Karya Mahasiswa TPL Sekolah Vokasi IPB University</h2>
            <div class="w-24 h-1.5 bg-gradient-to-r from-indigo-600 to-indigo-400 rounded-full mx-auto mt-6"></div>
        </div>
        
        {{-- Search Bar --}}
        <div class="max-w-2xl mx-auto mb-10 fade-in-up">
            <form action="{{ route('karya.public') }}" method="GET" @submit.prevent="">
                <div class="relative flex items-center">
                    <span class="absolute left-4 text-gray-400 dark:text-gray-500">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" 
                           class="w-full pl-12 pr-24 py-4 rounded-full border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-all" 
                           name="search" 
                           x-model="searchQuery"
                           placeholder="Cari karya...">
                    <button class="absolute right-2 top-2 bottom-2 px-6 bg-indigo-600 text-white font-semibold rounded-full hover:bg-indigo-700 transition-colors shadow-sm" type="button" @click="searchQuery = searchQuery">Cari</button>
                </div>
            </form>
        </div>

        {{-- Filter Kategori --}}
        <div class="flex flex-wrap justify-center gap-3 mb-16 fade-in-up">
            <a href="#" 
               @click.prevent="selectedCategory = 'Semua'"
               :class="selectedCategory === 'Semua' ? 'bg-indigo-600 text-white' : 'bg-white dark:bg-gray-800 text-indigo-600 dark:text-indigo-400 border border-indigo-200 dark:border-gray-700 hover:border-indigo-500 hover:text-indigo-700 dark:hover:text-indigo-300'"
               class="px-5 py-2 rounded-full text-sm font-semibold transition-all shadow-sm">
                Semua
            </a>
            @foreach(['Web Development', 'Mobile Apps', 'Data Science', 'IoT', 'Game Development'] as $kat)
            <a href="#" 
               @click.prevent="selectedCategory = '{{ $kat }}'"
               :class="selectedCategory === '{{ $kat }}' ? 'bg-indigo-600 text-white' : 'bg-white dark:bg-gray-800 text-indigo-600 dark:text-indigo-400 border border-indigo-200 dark:border-gray-700 hover:border-indigo-500 hover:text-indigo-700 dark:hover:text-indigo-300'"
               class="px-5 py-2 rounded-full text-sm font-semibold transition-all shadow-sm">
                {{ $kat }}
            </a>
            @endforeach
        </div>
            
        {{-- Grid Karya --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse ($karya as $k)
                <div class="karya-card bg-white dark:bg-gray-800 rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col group border border-gray-100 dark:border-gray-700 fade-in-up"
                     x-show="filterKarya('{{ addslashes($k->judul) }}', '{{ addslashes($k->kategori) }}', '{{ addslashes($k->tim_pembuat) }}', '{{ addslashes(Str::limit(strip_tags($k->deskripsi), 200)) }}')">
                    
                    <div class="relative overflow-hidden h-64 bg-gray-100 dark:bg-gray-900 flex items-center justify-center">
                        @if($k->preview_karya)
                            <img src="{{ asset('storage/' . $k->preview_karya) }}" 
                                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" 
                                 alt="{{ $k->judul }}">
                        @else
                            <span class="text-xl font-bold text-gray-400 dark:text-gray-600">{{ $k->judul }}</span>
                        @endif
                        <div class="absolute top-4 left-4">
                            <span class="px-3 py-1 bg-indigo-600 text-white text-xs font-bold rounded-full shadow-sm">{{ $k->kategori }}</span>
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
                                {{ number_format($avgRating, 1) }} ({{ $reviewCount }} ulasan)
                            </span>
                        </div>
                        
                        <div class="mt-auto">
                            <a href="{{ route('karya.public.show', $k->id) }}" 
                               class="inline-flex justify-center w-full px-4 py-2 bg-indigo-50 dark:bg-gray-700 text-indigo-600 dark:text-indigo-300 font-semibold rounded-lg hover:bg-indigo-100 dark:hover:bg-gray-600 transition-colors">
                                Selengkapnya
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full">
                    <div class="bg-blue-50 border border-blue-200 text-blue-700 px-6 py-4 rounded-xl flex items-center justify-center">
                        <i class="bi bi-info-circle mr-3 text-xl"></i>
                        <span class="font-medium">Tidak ada karya yang ditemukan.</span>
                    </div>
                </div>
            @endforelse

            {{-- Dynamic No Results Message --}}
            <div class="col-span-full" id="no-karya-results" style="display: none;">
                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 text-blue-700 dark:text-blue-400 px-6 py-4 rounded-xl flex items-center justify-center">
                    <i class="bi bi-info-circle mr-3 text-xl"></i>
                    <span class="font-medium">Tidak ada karya yang cocok dengan pencarian atau filter Anda.</span>
                </div>
            </div>
        </div>

        {{-- Tombol Kembali --}}
        <div class="text-center mt-12 mb-4">
            <a href="{{ route('home') }}" class="inline-flex items-center px-6 py-3 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-200 font-semibold rounded-xl border border-gray-200 dark:border-gray-700 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors shadow-sm">
                <i class="bi bi-arrow-left mr-2"></i>Kembali ke Home
            </a>
        </div>

    </div>
</section>
@endsection