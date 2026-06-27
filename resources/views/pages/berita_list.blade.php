@extends('layouts.app')

@section('title', 'Berita & Kegiatan - Portal Karya TRPL')

@section('hero')
@include('partials.hero', [
    'title' => 'Berita & Kegiatan',
    'subtitle' => 'Informasi terbaru seputar Program Studi Teknologi Rekayasa Perangkat Lunak'
])
@endsection

@section('content')
<main class="py-20 bg-gray-50 dark:bg-gray-900 transition-colors duration-300 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Search & Filter Bar -->
        <div class="mb-12" x-data="{ search: '' }">
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-4 sm:p-6 shadow-sm border border-gray-100 dark:border-gray-700 flex flex-col md:flex-row gap-4 items-center justify-between">
                <div class="relative w-full md:w-96">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="bi bi-search text-gray-400"></i>
                    </span>
                    <input type="text" 
                           placeholder="Cari berita..." 
                           class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 text-gray-955 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all text-sm"
                           id="news-search-input">
                </div>
                <div class="flex items-center gap-2 text-xs font-semibold text-gray-500 dark:text-gray-400">
                    <i class="bi bi-info-circle"></i>
                    <span>Menampilkan {{ $berita->count() }} berita/kegiatan</span>
                </div>
            </div>
        </div>

        @if($berita->isEmpty())
            <div class="text-center py-20 bg-white dark:bg-gray-800 rounded-3xl border border-dashed border-gray-200 dark:border-gray-700">
                <div class="w-16 h-16 bg-indigo-50 dark:bg-indigo-950/40 rounded-full flex items-center justify-center mx-auto text-indigo-600 dark:text-indigo-400 mb-4">
                    <i class="bi bi-newspaper text-2xl"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1">Belum ada berita</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">Silakan kembali lagi nanti untuk informasi terbaru.</p>
            </div>
        @else
            <!-- News Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="news-grid">
                @foreach ($berita as $item)
                    <div class="bg-white dark:bg-gray-800 rounded-3xl overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 border border-gray-100 dark:border-gray-700/50 flex flex-col group news-card" data-title="{{ strtolower($item->judul) }}">
                        <!-- Image Container -->
                        <div class="relative overflow-hidden aspect-[16/10] bg-gray-100 dark:bg-gray-700" x-data="{ loaded: false }" x-init="if ($refs.img && $refs.img.complete) loaded = true">
                            <img x-ref="img" 
                                 src="{{ asset('storage/' . $item->gambar) }}" 
                                 alt="{{ $item->judul }}"
                                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                                 loading="lazy"
                                 @load="loaded = true"
                                 :class="loaded ? 'opacity-100' : 'opacity-0'">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                        </div>

                        <!-- Content -->
                        <div class="p-6 sm:p-8 flex flex-col flex-grow">
                            <!-- Meta Info -->
                            <div class="flex items-center text-xs font-semibold text-gray-400 dark:text-gray-500 mb-3 gap-3">
                                <span class="flex items-center">
                                    <i class="bi bi-calendar-event mr-1.5 text-indigo-500"></i>
                                    {{ \Carbon\Carbon::parse($item->tanggal_publikasi ?? $item->created_at)->translatedFormat('d F Y') }}
                                </span>
                            </div>

                            <!-- Title -->
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors line-clamp-2 leading-snug">
                                <a href="{{ route('berita.show', $item->id) }}">
                                    {{ $item->judul }}
                                </a>
                            </h3>

                            <!-- Excerpt -->
                            <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed mb-6 line-clamp-3">
                                {{ $item->excerpt }}
                            </p>

                            <!-- Read More Link -->
                            <div class="mt-auto pt-4 border-t border-gray-100 dark:border-gray-700/50 flex items-center justify-between">
                                <span class="text-xs font-semibold text-gray-400 dark:text-gray-500 flex items-center">
                                    <i class="bi bi-person mr-1.5"></i> Admin Portal
                                </span>
                                <a href="{{ route('berita.show', $item->id) }}" class="text-xs font-bold text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 flex items-center gap-1 group/link">
                                    Selengkapnya 
                                    <i class="bi bi-arrow-right group-hover/link:translate-x-1 transition-transform"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </div>
</main>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('news-search-input');
        const cards = document.querySelectorAll('.news-card');

        if (searchInput) {
            searchInput.addEventListener('input', function(e) {
                const query = e.target.value.toLowerCase().trim();
                
                cards.forEach(card => {
                    const title = card.getAttribute('data-title');
                    if (title.includes(query)) {
                        card.style.display = 'flex';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        }
    });
</script>
@endpush
@endsection
