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

                <article class="prose prose-lg dark:prose-invert max-w-none prose-indigo leading-relaxed text-gray-700 dark:text-gray-300">
                    {{$berita->isi}}
                </article>

                <hr class="my-10 border-gray-200 dark:border-gray-700">

                <div class="flex flex-col sm:flex-row items-center justify-between gap-6">
                    <div class="flex items-center">
                        <strong class="text-gray-900 dark:text-white mr-4">Bagikan Artikel:</strong>
                        <div class="flex space-x-3">
                            <a href="#" class="w-10 h-10 flex items-center justify-center rounded-full bg-blue-100 text-blue-600 hover:bg-blue-600 hover:text-white transition-colors"><i class="bi bi-facebook text-lg"></i></a>
                            <a href="#" class="w-10 h-10 flex items-center justify-center rounded-full bg-sky-100 text-sky-500 hover:bg-sky-500 hover:text-white transition-colors"><i class="bi bi-twitter text-lg"></i></a>
                            <a href="#" class="w-10 h-10 flex items-center justify-center rounded-full bg-green-100 text-green-500 hover:bg-green-500 hover:text-white transition-colors"><i class="bi bi-whatsapp text-lg"></i></a>
                        </div>
                    </div>

                    <a href="{{ route('home') }}" class="inline-flex items-center px-6 py-3 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 font-semibold rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                        <i class="bi bi-arrow-left mr-2"></i>Kembali ke Home
                    </a>
                </div>

            </div>

        </div>
    </main>
@endsection