@extends('layouts.app')

@section('title', $berita->judul . ' - Berita TPL SVIPB')

@section('meta')
    <meta property="og:title" content="{{ $berita->judul }} - Berita TRPL IPB">
    <meta property="og:description" content="{{ Str::limit(strip_tags($berita->isi), 150) }}">
    <meta property="og:image" content="{{ asset('storage/' . $berita->gambar) }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="article">
@endsection



@section('hero')
@include('partials.hero', [
    'title' => 'Berita & Kegiatan',
    'subtitle' => $berita->judul
])
@endsection

@section('content')
    <main class="py-20 bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 fade-in-up">
            
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 sm:p-10 md:p-12 mb-8">

                <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-gray-900 dark:text-white leading-tight mb-6">
                    {{ $berita->judul }}
                </h1>

                <div class="flex flex-wrap items-center text-sm font-medium text-gray-500 dark:text-gray-400 mb-8 pb-8 border-b border-gray-200 dark:border-gray-700">
                    <span class="flex items-center mr-6 mb-2 sm:mb-0">
                        <i class="bi bi-person-circle mr-2 text-indigo-500"></i> Admin Portal
                    </span>
                    <span class="flex items-center">
                        <i class="bi bi-calendar-event-fill mr-2 text-indigo-500"></i>
                        {{ \Carbon\Carbon::parse($berita->created_at)->translatedFormat('d F Y') }}
                    </span>
                </div>

                <div class="rounded-2xl overflow-hidden mb-10 shadow-md bg-gray-200 dark:bg-gray-700" :class="loaded ? '' : 'animate-pulse'" x-data="{ loaded: false }" x-init="if ($refs.img && $refs.img.complete) loaded = true">
                    <img x-ref="img" src="{{ asset('storage/' . $berita->gambar) }}" alt="{{ $berita->judul }}"
                        class="w-full h-auto max-h-[500px] object-cover hover:scale-105 transition-all duration-700"
                        loading="lazy"
                        @load="loaded = true"
                        :class="loaded ? 'opacity-100' : 'opacity-0'">
                </div>

                <article class="prose prose-lg dark:prose-invert max-w-none prose-indigo leading-relaxed text-gray-700 dark:text-gray-300 mb-12">
                    {!! nl2br(e($berita->isi)) !!}
                </article>

                <hr class="my-10 border-gray-200 dark:border-gray-700">

                <div class="flex flex-col sm:flex-row items-center justify-between gap-6">
                    <div class="flex flex-wrap items-center gap-4">
                        <strong class="text-gray-900 dark:text-white mr-2">Bagikan Artikel:</strong>
                        <div class="flex items-center gap-2">
                            <!-- WhatsApp -->
                            <a href="https://api.whatsapp.com/send?text={{ rawurlencode('Yuk baca berita ini: ' . $berita->judul . ' - ' . url()->current()) }}" 
                               target="_blank" 
                               class="w-10 h-10 flex items-center justify-center rounded-xl bg-[#25D366]/10 text-[#25D366] hover:bg-[#25D366] hover:text-white transition-all transform hover:-translate-y-0.5"
                               title="Bagikan ke WhatsApp">
                                <i class="bi bi-whatsapp text-lg"></i>
                            </a>
                            <!-- Facebook -->
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" 
                               target="_blank" 
                               class="w-10 h-10 flex items-center justify-center rounded-xl bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400 hover:bg-blue-600 hover:text-white dark:hover:bg-blue-600 dark:hover:text-white transition-all transform hover:-translate-y-0.5"
                               title="Bagikan ke Facebook">
                                <i class="bi bi-facebook text-lg"></i>
                            </a>
                            <!-- X (Twitter) -->
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($berita->judul) }}" 
                               target="_blank" 
                               class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-100 text-gray-900 dark:bg-gray-700 dark:text-gray-200 hover:bg-gray-900 hover:text-white dark:hover:bg-white dark:hover:text-gray-900 transition-all transform hover:-translate-y-0.5"
                               title="Bagikan ke X">
                                <i class="bi bi-twitter-x text-lg"></i>
                            </a>
                            <!-- Copy Link Button -->
                            <button id="btn-copy-news-link" data-url="{{ url()->current() }}"
                                    class="flex items-center justify-center w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 dark:bg-indigo-950/40 dark:text-indigo-400 border border-indigo-100 dark:border-indigo-900/30 hover:bg-indigo-600 hover:text-white hover:border-indigo-600 transition-all transform hover:-translate-y-0.5 group"
                                    title="Salin Tautan">
                                <i id="copy-news-icon" class="bi bi-link-45deg text-xl"></i>
                            </button>
                        </div>
                    </div>

                    <a href="{{ route('home') }}" class="inline-flex items-center px-6 py-3.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 font-bold rounded-xl transition-all shadow-sm">
                        <i class="bi bi-arrow-left mr-2"></i>Kembali ke Home
                    </a>
                </div>

            </div>

        </div>
    </main>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const btnCopyLink = document.getElementById('btn-copy-news-link');
                if (btnCopyLink) {
                    btnCopyLink.addEventListener('click', function() {
                        const url = this.getAttribute('data-url');
                        navigator.clipboard.writeText(url).then(() => {
                            const icon = document.getElementById('copy-news-icon');
                            icon.className = 'bi bi-check-lg text-green-500';
                            btnCopyLink.classList.remove('bg-indigo-50', 'text-indigo-600');
                            btnCopyLink.classList.add('bg-green-50', 'border-green-300');
                            
                            setTimeout(() => {
                                icon.className = 'bi bi-link-45deg';
                                btnCopyLink.classList.add('bg-indigo-50', 'text-indigo-600');
                                btnCopyLink.classList.remove('bg-green-50', 'border-green-300');
                            }, 2000);
                        }).catch(err => {
                            console.error('Gagal menyalin tautan: ', err);
                        });
                    });
                }
            });
        </script>
    @endpush
@endsection