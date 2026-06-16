@extends('layouts.app')

@section('title', 'Halaman Utama')



{{-- BAGIAN HERO --}}
@section('hero')
@include('partials.hero', [
    'title' => 'Selamat Datang di Portal TRPL',
    'subtitle' => 'Portal Resmi Program Studi Teknologi Rekayasa Perangkat Lunak SV IPB University'
])
@endsection

@section('content')

{{-- NOTIFIKASI: Hanya muncul jika session 'show_welcome' ada --}}
@if (session('show_welcome') && Auth::check())
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
    <div x-data="{ show: true }" x-show="show" 
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-4"
         class="relative bg-gradient-to-r from-emerald-50 to-green-50 dark:from-emerald-950/30 dark:to-green-950/30 border border-emerald-200 dark:border-emerald-800/50 text-emerald-800 dark:text-emerald-300 px-6 py-4 rounded-2xl text-center mb-6 shadow-sm" role="alert">
        <i class="bi bi-hand-thumbs-up-fill mr-2"></i>
        Selamat datang, <strong>{{ Auth::user()->name }}!</strong>
        <button @click="show = false" type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3 text-emerald-500 hover:text-emerald-700 transition-colors">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>
</div>
@endif

<section class="py-16 bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
    
    {{-- BAGIAN HIGHLIGHT PORTAL --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-20 fade-in-up">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @php
                $highlights = [
                    ['icon' => 'bi-rocket-takeoff', 'title' => 'Inovasi Berkelanjutan', 'desc' => 'Portal ini menjadi wadah utama bagi mahasiswa TRPL untuk memamerkan solusi teknologi yang relevan dengan kebutuhan industri masa kini.', 'color' => 'indigo', 'gradient' => 'from-indigo-500 to-purple-500'],
                    ['icon' => 'bi-people', 'title' => 'Kolaborasi Tim', 'desc' => 'Setiap karya merupakan hasil kerja keras tim mahasiswa yang mengedepankan kolaborasi, komunikasi, dan manajemen proyek yang baik.', 'color' => 'emerald', 'gradient' => 'from-emerald-500 to-teal-500'],
                    ['icon' => 'bi-star', 'title' => 'Standar Industri', 'desc' => 'Aplikasi yang dikembangkan berpedoman pada standar industri teknologi, mulai dari UI/UX, keamanan, hingga efisiensi sistem.', 'color' => 'amber', 'gradient' => 'from-amber-500 to-orange-500'],
                ];
            @endphp

            @foreach ($highlights as $i => $h)
            <div class="group bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-xl transition-all duration-500 relative overflow-hidden glow-ring">
                {{-- Decorative gradient orb --}}
                <div class="absolute -right-8 -top-8 w-32 h-32 bg-gradient-to-br {{ $h['gradient'] }} rounded-full opacity-[0.06] group-hover:opacity-[0.12] group-hover:scale-125 transition-all duration-500"></div>
                
                <div class="w-14 h-14 bg-{{ $h['color'] }}-100 dark:bg-{{ $h['color'] }}-900/40 text-{{ $h['color'] }}-600 dark:text-{{ $h['color'] }}-400 rounded-2xl flex items-center justify-center mb-6 relative z-10 group-hover:scale-110 transition-transform duration-300">
                    <i class="bi {{ $h['icon'] }} text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3 relative z-10 group-hover:text-{{ $h['color'] }}-600 dark:group-hover:text-{{ $h['color'] }}-400 transition-colors">{{ $h['title'] }}</h3>
                <p class="text-gray-600 dark:text-gray-400 relative z-10 leading-relaxed">{{ $h['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>

    {{-- BAGIAN STATISTIK PORTAL --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-24 fade-in-up"
         x-data="{
             countKarya: 0,
             countDosen: 0,
             countReview: 0,
             countMatkul: 0,
             targetKarya: {{ $karyas_count }},
             targetDosen: {{ $dosens_count }},
             targetReview: {{ $reviews_count }},
             targetMatkul: {{ $matkuls_count }},
             animated: false,
             animate() {
                 if (this.animated) return;
                 this.animated = true;
                 const duration = 1500;
                 const steps = 60;
                 const stepTime = duration / steps;
                 let step = 0;
                 const easeOutCubic = (t) => 1 - Math.pow(1 - t, 3);
                 const timer = setInterval(() => {
                     step++;
                     const progress = easeOutCubic(step / steps);
                     this.countKarya = Math.round(this.targetKarya * progress);
                     this.countDosen = Math.round(this.targetDosen * progress);
                     this.countReview = Math.round(this.targetReview * progress);
                     this.countMatkul = Math.round(this.targetMatkul * progress);
                     
                     if (step >= steps) {
                         this.countKarya = this.targetKarya;
                         this.countDosen = this.targetDosen;
                         this.countReview = this.targetReview;
                         this.countMatkul = this.targetMatkul;
                         clearInterval(timer);
                     }
                 }, stepTime);
             }
         }"
         x-init="
             const observer = new IntersectionObserver((entries) => {
                 if (entries[0].isIntersecting) {
                     animate();
                 }
             }, { threshold: 0.1 });
             observer.observe($el);
         ">
        <div class="bg-gradient-to-br from-indigo-50/80 via-white to-purple-50/50 dark:from-gray-800 dark:via-gray-800/90 dark:to-gray-800 rounded-3xl shadow-lg border border-indigo-100/50 dark:border-gray-700/50 p-8 sm:p-12 transition-colors duration-300 relative overflow-hidden">
            {{-- Decorative background --}}
            <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-indigo-200/20 to-purple-200/20 dark:from-indigo-900/10 dark:to-purple-900/10 rounded-full blur-3xl -mr-32 -mt-32"></div>
            
            <div class="text-center mb-12 relative z-10">
                <span class="inline-flex items-center gap-2 text-xs font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-widest bg-indigo-50 dark:bg-indigo-950/40 px-4 py-1.5 rounded-full border border-indigo-100 dark:border-indigo-900/30">
                    <i class="bi bi-graph-up-arrow"></i>
                    Aktivitas Sistem
                </span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight mt-4">Portal dalam Angka</h2>
                <div class="w-16 h-1 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-full mx-auto mt-4"></div>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8 relative z-10">
                @php
                    $stats = [
                        ['icon' => 'bi-file-earmark-code', 'label' => 'Karya Terpublikasi', 'model' => 'countKarya', 'color' => 'indigo'],
                        ['icon' => 'bi-person-badge', 'label' => 'Dosen', 'model' => 'countDosen', 'color' => 'emerald'],
                        ['icon' => 'bi-chat-left-heart', 'label' => 'Ulasan Pengguna', 'model' => 'countReview', 'color' => 'amber'],
                        ['icon' => 'bi-journal-code', 'label' => 'Mata Kuliah TRPL', 'model' => 'countMatkul', 'color' => 'pink'],
                    ];
                @endphp

                @foreach ($stats as $stat)
                <div class="text-center p-6 bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-3xl border border-gray-100/80 dark:border-gray-700/50 shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-400 group">
                    <div class="w-14 h-14 bg-{{ $stat['color'] }}-100 dark:bg-{{ $stat['color'] }}-900/40 text-{{ $stat['color'] }}-600 dark:text-{{ $stat['color'] }}-400 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                        <i class="bi {{ $stat['icon'] }} text-xl"></i>
                    </div>
                    <div class="text-3xl sm:text-4xl font-extrabold text-gray-900 dark:text-white tracking-tight tabular-nums" x-text="{{ $stat['model'] }}">0</div>
                    <div class="text-xs sm:text-sm font-semibold text-gray-500 dark:text-gray-400 mt-2">{{ $stat['label'] }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
            
    {{-- BAGIAN KARYA MAHASISWA --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-24">
        <div class="text-center mb-14">
            <span class="inline-flex items-center gap-2 text-xs font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-widest bg-indigo-50 dark:bg-indigo-950/40 px-4 py-1.5 rounded-full border border-indigo-100 dark:border-indigo-900/30 mb-4">
                <i class="bi bi-collection"></i>
                Karya Terbaru
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 dark:text-white tracking-tight">Kumpulan Karya Mahasiswa<br class="hidden sm:block"/>Teknologi Rekayasa Perangkat Lunak</h2>
            <div class="w-24 h-1.5 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-full mx-auto mt-6"></div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($karyas as $karya)
            <div class="karya-card bg-white dark:bg-gray-800 rounded-2xl shadow-sm overflow-hidden flex flex-col group border border-gray-100 dark:border-gray-700 fade-in-up">
                <div class="relative overflow-hidden h-56 bg-gray-200 dark:bg-gray-700" :class="loaded ? '' : 'animate-pulse'" x-data="{ loaded: false }" x-init="if ($refs.img && $refs.img.complete) loaded = true">
                    <img x-ref="img" src="{{ $karya->preview_karya ? asset('storage/' . $karya->preview_karya) : 'https://placehold.co/600x400/333/white?text=Aplikasi+1' }}" 
                         class="w-full h-full object-cover transition-all duration-700 group-hover:scale-110" 
                         loading="lazy"
                         @load="loaded = true"
                         :class="loaded ? 'opacity-100' : 'opacity-0'"
                         alt="Karya Mahasiswa">
                    {{-- Overlay gradient on hover --}}
                    <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="absolute top-4 left-4">
                        <span class="px-3 py-1.5 bg-indigo-600/90 backdrop-blur-sm text-white text-xs font-bold rounded-full shadow-lg">{{ $karya->kategori }}</span>
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
                                <i class="bi bi-star text-gray-300 dark:text-gray-600"></i>
                            @endif
                        @endfor
                        <span class="ml-2 text-sm text-gray-500 dark:text-gray-400 font-medium">
                            {{ number_format($avgRating, 1) }} ({{ $reviewCount }})
                        </span>
                    </div>
                    
                    <div class="mt-auto">
                        <a href="{{ route('karya.public.show', $karya->id) }}" class="inline-flex justify-center items-center w-full px-4 py-2.5 bg-indigo-50 dark:bg-gray-700 text-indigo-600 dark:text-indigo-300 font-semibold rounded-xl hover:bg-indigo-100 dark:hover:bg-gray-600 transition-all group/btn">
                            Selengkapnya
                            <i class="bi bi-arrow-right ml-2 group-hover/btn:translate-x-1 transition-transform"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-14 flex flex-col sm:flex-row items-center justify-center space-y-4 sm:space-y-0 sm:space-x-6">
            <a href="{{ route('karya.public') }}" class="w-full sm:w-auto px-8 py-4 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white font-bold rounded-xl hover:from-indigo-700 hover:to-indigo-800 shadow-lg hover:shadow-xl transition-all text-center hover:-translate-y-0.5 ripple">
                <i class="bi bi-search mr-2"></i>Cari Karya Lainnya
            </a>
            <a href="{{ route('unggah') }}" class="w-full sm:w-auto px-8 py-4 bg-white dark:bg-gray-800 text-indigo-600 dark:text-indigo-400 font-bold rounded-xl border-2 border-indigo-200 dark:border-gray-700 hover:border-indigo-500 dark:hover:border-indigo-500 hover:bg-indigo-50 dark:hover:bg-gray-700 shadow-sm transition-all text-center hover:-translate-y-0.5">
                <i class="bi bi-upload mr-2"></i>Unggah Karya
            </a>
        </div>
    </div>
    
    {{-- BAGIAN BERITA --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-24">
        <div class="bg-white dark:bg-gray-800 rounded-3xl p-8 sm:p-12 shadow-sm border border-gray-100 dark:border-gray-700 relative overflow-hidden">
            {{-- Decorative --}}
            <div class="absolute top-0 right-0 w-48 h-48 bg-gradient-to-bl from-indigo-50 dark:from-indigo-950/20 to-transparent rounded-bl-full"></div>
            
            <div class="text-center mb-12 relative z-10">
                <span class="inline-flex items-center gap-2 text-xs font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-widest bg-indigo-50 dark:bg-indigo-950/40 px-4 py-1.5 rounded-full border border-indigo-100 dark:border-indigo-900/30 mb-4">
                    <i class="bi bi-newspaper"></i>
                    Informasi Terkini
                </span>
                <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white">Berita TPL Sekolah Vokasi IPB University</h2>
            </div>

            <div class="max-w-4xl mx-auto space-y-6 relative z-10">
                @foreach ($beritas as $berita)
                <div class="bg-gray-50 dark:bg-gray-900/50 rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100 dark:border-gray-800 fade-in-up group">
                    <div class="flex flex-col sm:flex-row">
                        <div class="sm:w-1/3 overflow-hidden">
                            <a href="{{ route('berita.show', $berita->id) }}" class="block h-full relative bg-gray-200 dark:bg-gray-700" :class="loaded ? '' : 'animate-pulse'" x-data="{ loaded: false }" x-init="if ($refs.img && $refs.img.complete) loaded = true">
                                <img x-ref="img" src="{{ asset('storage/' . $berita->gambar ) }}" 
                                     class="w-full h-48 sm:h-full object-cover transition-all duration-500 group-hover:scale-105" 
                                     loading="lazy"
                                     @load="loaded = true"
                                     :class="loaded ? 'opacity-100' : 'opacity-0'"
                                     alt="{{ $berita->judul }}">
                            </a>
                        </div>

                        <div class="sm:w-2/3 p-6 sm:p-8 flex flex-col justify-center">
                            <h5 class="text-xl font-bold text-gray-900 dark:text-white mb-3 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                                <a href="{{ route('berita.show', $berita->id) }}">
                                    {{ $berita->judul }}
                                </a>
                            </h5>

                            <p class="text-gray-600 dark:text-gray-400 mb-4 line-clamp-3 leading-relaxed">
                                {{ Str::limit($berita->isi, 120) }}
                            </p>

                            <div class="flex items-center justify-between">
                                <div class="flex items-center text-sm text-gray-500 dark:text-gray-500 font-medium">
                                    <i class="bi bi-calendar3 mr-2 text-indigo-400"></i>
                                    {{ \Carbon\Carbon::parse($berita->created_at)->translatedFormat('d F Y') }}
                                </div>
                                <a href="{{ route('berita.show', $berita->id) }}" class="text-sm font-semibold text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 transition-colors flex items-center gap-1">
                                    Baca <i class="bi bi-arrow-right"></i>
                                </a>
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
        <div class="relative rounded-3xl overflow-hidden bg-gradient-to-br from-indigo-900 via-indigo-800 to-purple-900 p-10 sm:p-16 text-center text-white shadow-2xl">
            <!-- Decorative Elements -->
            <div class="absolute -top-24 -right-24 w-64 h-64 bg-white opacity-[0.06] rounded-full blur-2xl animate-blob"></div>
            <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-white opacity-[0.06] rounded-full blur-2xl animate-blob animation-delay-2000"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-gradient-to-r from-indigo-500/10 to-purple-500/10 rounded-full blur-3xl animate-pulse"></div>
            
            <div class="relative z-10 max-w-2xl mx-auto">
                <span class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-widest bg-white/10 backdrop-blur-sm px-4 py-1.5 rounded-full border border-white/10 mb-6">
                    <i class="bi bi-mortarboard-fill"></i>
                    Penerimaan Mahasiswa Baru
                </span>
                <h2 class="text-3xl sm:text-4xl font-extrabold mb-4 leading-tight">Bergabunglah Bersama TRPL<br class="hidden sm:block"/> Sekolah Vokasi IPB University</h2>
                <p class="text-lg sm:text-xl text-indigo-100/90 mb-10 leading-relaxed">
                    Jadilah bagian dari generasi inovator digital. Dapatkan pendidikan vokasi terbaik di bidang rekayasa perangkat lunak.
                </p>
                <a href="https://admisi.ipb.ac.id" target="_blank" class="inline-flex items-center justify-center px-8 py-4 bg-white text-indigo-700 font-extrabold rounded-2xl hover:bg-gray-50 hover:scale-105 transition-all shadow-lg text-lg ripple">
                    Informasi Pendaftaran <i class="bi bi-arrow-right ml-3 text-xl"></i>
                </a>
            </div>
        </div>
    </div>

</section>
@endsection