@extends('layouts.app')

@section('title', $karya->judul . ' - Karya Mahasiswa')

@section('meta')
    <meta property="og:title" content="{{ $karya->judul }} - Karya Mahasiswa TRPL IPB">
    <meta property="og:description" content="{{ Str::limit(strip_tags($karya->deskripsi), 150) }}">
    <meta property="og:image" content="{{ asset('storage/' . $karya->preview_karya) }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
@endsection



@section('hero')
@include('partials.hero', [
    'title' => $karya->judul,
    'subtitle' => 'Kategori: ' . $karya->kategori . ' | Angkatan ' . $karya->tahun
])
@endsection

@section('content')
    <main class="py-20 bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- Main Content --}}
                <div class="lg:col-span-2 space-y-8 fade-in-up">
                    {{-- Author Card --}}
                    <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 shadow-md border border-gray-100 dark:border-gray-750 flex flex-col sm:flex-row items-center sm:items-start justify-between gap-6 relative overflow-hidden group">
                        <div class="absolute -right-16 -bottom-16 w-36 h-36 bg-indigo-50 dark:bg-indigo-950/20 rounded-full opacity-40 group-hover:scale-110 transition-transform duration-500"></div>
                        <div class="flex items-center gap-4 relative z-10">
                            <div class="relative">
                                <div class="absolute inset-0 bg-gradient-to-tr from-indigo-500 to-purple-500 rounded-full blur opacity-40 group-hover:opacity-70 transition-opacity"></div>
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($karya->tim_pembuat) }}&background=4F46E5&color=fff&size=80"
                                    alt="Avatar Penulis" class="relative w-20 h-20 rounded-full shadow-md border-2 border-white dark:border-gray-800 object-cover">
                            </div>
                            <div>
                                <h5 class="text-xl font-bold text-gray-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">{{$karya->tim_pembuat}}</h5>
                                <span class="text-xs px-2.5 py-0.5 rounded-full bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 font-bold border border-indigo-100 dark:border-indigo-800">Tim Pembuat</span>
                            </div>
                        </div>
                        
                        <div class="text-center sm:text-right">
                            @php
                                $avgRating = $karya->reviews->avg('rating') ?? 0;
                                $reviewCount = $karya->reviews->count();
                            @endphp

                            <div class="flex text-yellow-400 text-lg mb-1 justify-center sm:justify-end">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= floor($avgRating))
                                        <i class="bi bi-star-fill"></i>
                                    @elseif ($i <= ceil($avgRating) && $avgRating - floor($avgRating) >= 0.5)
                                        <i class="bi bi-star-half"></i>
                                    @else
                                        <i class="bi bi-star text-gray-300 dark:text-gray-600"></i>
                                    @endif
                                @endfor
                            </div>

                            <small class="text-gray-500 dark:text-gray-400 font-medium">
                                {{ number_format($avgRating, 1) }} ({{ $reviewCount }} ulasan)
                            </small>
                        </div>
                    </div>

                    {{-- Project Card --}}
                    <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 sm:p-10 shadow-sm border border-gray-100 dark:border-gray-700">
                        <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-6">{{ $karya->judul }}</h2>
                        
                        <div class="rounded-2xl overflow-hidden mb-8 shadow-md border border-gray-100 dark:border-gray-700 bg-gray-100 dark:bg-gray-900" :class="loaded ? '' : 'animate-pulse'" x-data="{ loaded: false }" x-init="if ($refs.img && $refs.img.complete) loaded = true">
                            <img x-ref="img" src="{{ asset('storage/' . $karya->preview_karya) }}" alt="Screenshot Proyek"
                                class="w-full h-auto object-cover max-h-[600px] transition-opacity duration-300"
                                loading="lazy"
                                @load="loaded = true"
                                :class="loaded ? 'opacity-100' : 'opacity-0'">
                        </div>

                        <div class="prose prose-lg dark:prose-invert max-w-none text-gray-700 dark:text-gray-300 font-medium mb-10">
                            {{ $karya->deskripsi }}
                        </div>

                        <div class="flex flex-col sm:flex-row gap-4">
                            @if ($karya->link_pengumpulan)
                                <a href="{{ $karya->link_pengumpulan }}" target="_blank"
                                    class="flex-1 flex items-center justify-center py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-md hover:shadow-lg transition-all text-lg">
                                    <i class="bi bi-box-arrow-up-right mr-3"></i> Kunjungi Karya Ini
                                </a>
                            @endif

                            @if ($karya->file_karya)
                                <a href="{{ asset('storage/' . $karya->file_karya) }}" target="_blank"
                                    class="flex-1 flex items-center justify-center py-4 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl shadow-md hover:shadow-lg transition-all text-lg">
                                    <i class="bi bi-file-earmark-pdf mr-3"></i> Unduh PDF Dokumen
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Sidebar --}}
                <div class="space-y-8 fade-in-up" style="animation-delay: 0.2s;">
                    {{-- Feedback Form --}}
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                        <form action="{{ route('review.store') }}" method="post">
                            @csrf
                            @method('post')
                            <h5 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Tulis Umpan Balik</h5>
                            
                            <div class="flex justify-between items-center mb-4 bg-gray-50 dark:bg-gray-900/50 p-4 rounded-2xl border border-gray-200 dark:border-gray-700">
                                <div class="stars-input text-2xl text-gray-300 dark:text-gray-600 flex gap-2 cursor-pointer">
                                    <i class="bi bi-star transition-all duration-150 hover:scale-125 active:scale-90 transform" data-value="1"></i>
                                    <i class="bi bi-star transition-all duration-150 hover:scale-125 active:scale-90 transform" data-value="2"></i>
                                    <i class="bi bi-star transition-all duration-150 hover:scale-125 active:scale-90 transform" data-value="3"></i>
                                    <i class="bi bi-star transition-all duration-150 hover:scale-125 active:scale-90 transform" data-value="4"></i>
                                    <i class="bi bi-star transition-all duration-150 hover:scale-125 active:scale-90 transform" data-value="5"></i>
                                </div>
                                <span class="font-bold text-indigo-600 dark:text-indigo-400" id="rating-display">N/A</span>
                            </div>

                            <textarea name="comment" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors mb-4 resize-none" rows="4"
                                placeholder="Tulis reviewmu disini..."></textarea>
                            
                            <input type="hidden" name="rating" id="rating-value" value="0">
                            <input type="hidden" name="karya_id" value="{{ $karya->id }}">
                            
                            <button class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-md transition-colors" type="submit">Kirim Umpan Balik</button>
                        </form>
                    </div>

                    {{-- Bagikan Karya Card --}}
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 transition-all hover:shadow-md">
                        <h5 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Bagikan Karya</h5>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Bagikan karya inovatif ini ke rekan-rekan Anda melalui media sosial atau salin tautan langsung.</p>
                        
                        <div class="space-y-3">
                            <!-- Copy Link Button -->
                            <button id="btn-copy-link" data-url="{{ url()->current() }}"
                                class="flex items-center justify-between w-full px-4 py-3.5 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700/80 rounded-2xl hover:bg-indigo-50/50 dark:hover:bg-indigo-950/20 hover:border-indigo-300 dark:hover:border-indigo-800 text-gray-700 dark:text-gray-300 font-bold transition-all transform hover:-translate-y-0.5 duration-200">
                                <span class="flex items-center text-sm">
                                    <i class="bi bi-link-45deg text-xl mr-2 text-indigo-600 dark:text-indigo-400"></i>
                                    <span id="copy-text">Salin Tautan</span>
                                </span>
                                <i id="copy-icon" class="bi bi-clipboard text-gray-400"></i>
                            </button>

                            <!-- Social Shares Group -->
                            <div class="grid grid-cols-2 gap-3">
                                <a href="https://api.whatsapp.com/send?text={{ rawurlencode('Yuk lihat karya keren ini: ' . $karya->judul . ' - ' . url()->current()) }}"
                                    target="_blank"
                                    class="flex items-center justify-center gap-2 px-4 py-3 bg-green-550 hover:bg-green-600 text-white rounded-2xl font-bold text-sm shadow-sm hover:shadow-md transition-all transform hover:-translate-y-0.5 duration-200">
                                    <i class="bi bi-whatsapp"></i> WhatsApp
                                </a>
                                <a href="https://t.me/share/url?url={{ urlencode(url()->current()) }}&text={{ urlencode('Yuk lihat karya keren ini: ' . $karya->judul) }}"
                                    target="_blank"
                                    class="flex items-center justify-center gap-2 px-4 py-3 bg-sky-500 hover:bg-sky-600 text-white rounded-2xl font-bold text-sm shadow-sm hover:shadow-md transition-all transform hover:-translate-y-0.5 duration-200">
                                    <i class="bi bi-telegram"></i> Telegram
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Review List --}}
                    <div class="space-y-4">
                        <h4 class="text-lg font-bold text-gray-900 dark:text-white px-2">Ulasan Sebelumnya ({{ $review->count() }})</h4>
                        @foreach ($review as $r)
                            <div class="bg-white dark:bg-gray-800 rounded-xl p-5 shadow-sm border border-gray-100 dark:border-gray-700 transition-all hover:shadow-md">
                                <div class="flex items-start justify-between mb-3">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $r->user->foto ? asset('storage/' . $r->user->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($r->user->name) . '&background=random&color=fff' }}"
                                            alt="Avatar {{ $r->user->name }}" class="w-10 h-10 rounded-full object-cover shadow-sm">
                                        <div>
                                            <h6 class="font-bold text-gray-900 dark:text-white text-sm">{{ $r->user->name }}</h6>
                                            <small class="text-gray-500 dark:text-gray-400 text-xs">{{ $r->created_at->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                    <div class="flex text-yellow-400 text-xs">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $r->rating)
                                                <i class="bi bi-star-fill"></i>
                                            @else
                                                <i class="bi bi-star text-gray-300 dark:text-gray-600"></i>
                                            @endif
                                        @endfor
                                    </div>
                                </div>
                                <p class="text-gray-600 dark:text-gray-300 text-sm leading-relaxed">{{ $r->comment }}</p>
                            </div>
                        @endforeach
                    </div>

                    <div class="pt-6">
                        <a href="{{ route('karya.public') }}" class="flex items-center justify-center w-full py-3 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 font-semibold rounded-xl border border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors shadow-sm">
                            <i class="bi bi-arrow-left mr-2"></i>Kembali ke Daftar Karya
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </main>
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const starsInput = document.querySelector('.stars-input');
                const stars = document.querySelectorAll('.stars-input i');
                const ratingValInput = document.getElementById('rating-value');
                const ratingDisplay = document.getElementById('rating-display');

                function updateStars(value) {
                    stars.forEach((s, idx) => {
                        if (idx < value) {
                            s.classList.add('bi-star-fill', 'text-yellow-400');
                            s.classList.remove('bi-star', 'text-gray-300', 'dark:text-gray-600');
                        } else {
                            s.classList.remove('bi-star-fill', 'text-yellow-400');
                            s.classList.add('bi-star');
                        }
                    });
                }

                stars.forEach(star => {
                    star.addEventListener('click', function() {
                        const value = parseInt(this.getAttribute('data-value'));
                        ratingValInput.value = value;
                        ratingDisplay.textContent = value + '.0';
                        updateStars(value);
                    });

                    star.addEventListener('mouseenter', function() {
                        const value = parseInt(this.getAttribute('data-value'));
                        updateStars(value);
                    });
                });

                if (starsInput) {
                    starsInput.addEventListener('mouseleave', function() {
                        const currentValue = parseInt(ratingValInput.value) || 0;
                        if (currentValue === 0) {
                            // Reset to default grey state
                            stars.forEach(s => {
                                s.classList.remove('bi-star-fill', 'text-yellow-400');
                                s.classList.add('bi-star');
                            });
                            ratingDisplay.textContent = 'N/A';
                        } else {
                            updateStars(currentValue);
                            ratingDisplay.textContent = currentValue + '.0';
                        }
                    });
                }

                // Clipboard Copy Functionality
                const btnCopyLink = document.getElementById('btn-copy-link');
                if (btnCopyLink) {
                    btnCopyLink.addEventListener('click', function() {
                        const url = this.getAttribute('data-url');
                        navigator.clipboard.writeText(url).then(() => {
                            const copyText = document.getElementById('copy-text');
                            const copyIcon = document.getElementById('copy-icon');
                            
                            // Change state to Success
                            copyText.textContent = 'Disalin!';
                            copyText.classList.add('text-green-600', 'dark:text-green-400');
                            copyIcon.className = 'bi bi-check-lg text-green-600 dark:text-green-400';
                            
                            // Reset after 2 seconds
                            setTimeout(() => {
                                copyText.textContent = 'Salin Tautan';
                                copyText.classList.remove('text-green-600', 'dark:text-green-400');
                                copyIcon.className = 'bi bi-clipboard text-gray-400';
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