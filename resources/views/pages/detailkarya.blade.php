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
    <main class="py-20 bg-gray-50 dark:bg-gray-900 transition-colors duration-300" x-data="{ lightboxOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- Main Content --}}
                <div class="lg:col-span-2 space-y-8 fade-in-up">
                    {{-- Author Card --}}
                    <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 flex flex-col sm:flex-row items-center sm:items-start justify-between gap-6 relative overflow-hidden group glow-ring">
                        <div class="absolute -right-16 -bottom-16 w-40 h-40 bg-gradient-to-tl from-indigo-100 dark:from-indigo-950/20 to-transparent rounded-full opacity-50 group-hover:scale-125 transition-transform duration-500"></div>
                        <div class="flex items-center gap-4 relative z-10">
                            <div class="relative">
                                <div class="absolute inset-0 bg-gradient-to-tr from-indigo-500 to-purple-500 rounded-full blur opacity-30 group-hover:opacity-60 transition-opacity duration-300"></div>
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($karya->tim_pembuat) }}&background=4F46E5&color=fff&size=80"
                                    alt="Avatar Penulis" class="relative w-20 h-20 rounded-full shadow-md border-2 border-white dark:border-gray-800 object-cover group-hover:scale-105 transition-transform duration-300">
                            </div>
                            <div>
                                <h5 class="text-xl font-bold text-gray-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">{{$karya->tim_pembuat}}</h5>
                                <span class="inline-flex items-center gap-1.5 text-xs px-3 py-1 rounded-full bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 font-bold border border-indigo-100 dark:border-indigo-800 mt-1">
                                    <i class="bi bi-people-fill text-[10px]"></i> Tim Pembuat
                                </span>
                            </div>
                        </div>
                        
                        <div class="text-center sm:text-right relative z-10">
                            @php
                                $avgRating = $karya->reviews->avg('rating') ?? 0;
                                $reviewCount = $karya->reviews->count();
                            @endphp

                            <div class="flex text-yellow-400 text-lg mb-1 justify-center sm:justify-end gap-0.5">
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
                        
                        {{-- Image with Lightbox --}}
                        <div class="rounded-2xl overflow-hidden mb-8 shadow-md border border-gray-100 dark:border-gray-700 bg-gray-100 dark:bg-gray-900 cursor-pointer group/img" 
                             @click="lightboxOpen = true"
                             :class="loaded ? '' : 'animate-pulse'" x-data="{ loaded: false }" x-init="if ($refs.img && $refs.img.complete) loaded = true">
                            <div class="relative">
                                <img x-ref="img" src="{{ asset('storage/' . $karya->preview_karya) }}" alt="Screenshot Proyek"
                                    class="w-full h-auto object-cover max-h-[600px] transition-all duration-500 group-hover/img:scale-[1.02]"
                                    loading="lazy"
                                    @load="loaded = true"
                                    :class="loaded ? 'opacity-100' : 'opacity-0'">
                                <div class="absolute inset-0 bg-black/0 group-hover/img:bg-black/10 transition-all duration-300 flex items-center justify-center">
                                    <div class="w-12 h-12 rounded-full bg-white/80 backdrop-blur-sm flex items-center justify-center opacity-0 group-hover/img:opacity-100 transform scale-75 group-hover/img:scale-100 transition-all duration-300 shadow-lg">
                                        <i class="bi bi-arrows-fullscreen text-gray-700 text-lg"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="prose prose-lg dark:prose-invert max-w-none text-gray-700 dark:text-gray-300 font-medium mb-10 leading-relaxed">
                            {{ $karya->deskripsi }}
                        </div>

                        <div class="flex flex-col sm:flex-row gap-4">
                            @if ($karya->link_pengumpulan)
                                <a href="{{ $karya->link_pengumpulan }}" target="_blank"
                                    class="flex-1 flex items-center justify-center py-4 bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all text-lg ripple hover:-translate-y-0.5">
                                    <i class="bi bi-box-arrow-up-right mr-3"></i> Kunjungi Karya Ini
                                </a>
                            @endif

                            @if ($karya->file_karya)
                                <a href="{{ asset('storage/' . $karya->file_karya) }}" target="_blank"
                                    class="flex-1 flex items-center justify-center py-4 bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all text-lg ripple hover:-translate-y-0.5">
                                    <i class="bi bi-file-earmark-pdf mr-3"></i> Unduh PDF Dokumen
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Sidebar --}}
                <div class="space-y-8 fade-in-up" style="animation-delay: 0.2s;">
                    {{-- Feedback Form --}}
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 glow-ring">
                        <form action="{{ route('review.store') }}" method="post">
                            @csrf
                            @method('post')
                            <h5 class="text-xl font-bold text-gray-900 dark:text-white mb-1">Tulis Umpan Balik</h5>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-5">Berikan rating dan komentar untuk karya ini.</p>
                            
                            <div class="flex justify-between items-center mb-5 bg-gray-50 dark:bg-gray-900/50 p-4 rounded-2xl border border-gray-100 dark:border-gray-700">
                                <div class="stars-input text-2xl text-gray-300 dark:text-gray-600 flex gap-2 cursor-pointer">
                                    <i class="bi bi-star transition-all duration-200 hover:scale-125 active:scale-90 transform" data-value="1"></i>
                                    <i class="bi bi-star transition-all duration-200 hover:scale-125 active:scale-90 transform" data-value="2"></i>
                                    <i class="bi bi-star transition-all duration-200 hover:scale-125 active:scale-90 transform" data-value="3"></i>
                                    <i class="bi bi-star transition-all duration-200 hover:scale-125 active:scale-90 transform" data-value="4"></i>
                                    <i class="bi bi-star transition-all duration-200 hover:scale-125 active:scale-90 transform" data-value="5"></i>
                                </div>
                                <span class="font-bold text-indigo-600 dark:text-indigo-400 text-lg bg-indigo-50 dark:bg-indigo-900/30 px-3 py-1 rounded-lg" id="rating-display">N/A</span>
                            </div>

                            <textarea name="comment" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all mb-4 resize-none" rows="4"
                                placeholder="Tulis reviewmu disini..."></textarea>
                            
                            <input type="hidden" name="rating" id="rating-value" value="0">
                            <input type="hidden" name="karya_id" value="{{ $karya->id }}">
                            
                            <button class="w-full py-3.5 bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 text-white font-bold rounded-xl shadow-md hover:shadow-lg transition-all ripple flex items-center justify-center gap-2" type="submit">
                                <i class="bi bi-send-fill"></i> Kirim Umpan Balik
                            </button>
                        </form>
                    </div>

                    {{-- Bagikan Karya Card --}}
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 glow-ring">
                        <h5 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Bagikan Karya</h5>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-5">Bagikan karya inovatif ini ke rekan-rekan Anda.</p>
                        
                        <div class="space-y-3">
                            <!-- Copy Link Button -->
                            <button id="btn-copy-link" data-url="{{ url()->current() }}"
                                class="flex items-center justify-between w-full px-4 py-3.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl hover:bg-indigo-50/50 dark:hover:bg-indigo-950/20 hover:border-indigo-300 dark:hover:border-indigo-800 text-gray-700 dark:text-gray-300 font-bold transition-all transform hover:-translate-y-0.5 duration-200 group">
                                <span class="flex items-center text-sm">
                                    <i class="bi bi-link-45deg text-xl mr-2 text-indigo-600 dark:text-indigo-400 group-hover:rotate-12 transition-transform"></i>
                                    <span id="copy-text">Salin Tautan</span>
                                </span>
                                <i id="copy-icon" class="bi bi-clipboard text-gray-400"></i>
                            </button>

                            <!-- Social Shares Group -->
                            <div class="grid grid-cols-2 gap-3">
                                <a href="https://api.whatsapp.com/send?text={{ rawurlencode('Yuk lihat karya keren ini: ' . $karya->judul . ' - ' . url()->current()) }}"
                                    target="_blank"
                                    class="flex items-center justify-center gap-2 px-4 py-3 bg-[#25D366] hover:bg-[#20ba5a] text-white rounded-xl font-bold text-sm shadow-sm hover:shadow-md transition-all transform hover:-translate-y-0.5 duration-200 ripple">
                                    <i class="bi bi-whatsapp"></i> WhatsApp
                                </a>
                                <a href="https://t.me/share/url?url={{ urlencode(url()->current()) }}&text={{ urlencode('Yuk lihat karya keren ini: ' . $karya->judul) }}"
                                    target="_blank"
                                    class="flex items-center justify-center gap-2 px-4 py-3 bg-sky-500 hover:bg-sky-600 text-white rounded-xl font-bold text-sm shadow-sm hover:shadow-md transition-all transform hover:-translate-y-0.5 duration-200 ripple">
                                    <i class="bi bi-telegram"></i> Telegram
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Review List --}}
                    <div class="space-y-4">
                        <h4 class="text-lg font-bold text-gray-900 dark:text-white px-2 flex items-center gap-2">
                            <i class="bi bi-chat-square-text text-indigo-500"></i>
                            Ulasan Sebelumnya ({{ $review->count() }})
                        </h4>
                        @forelse ($review as $index => $r)
                            <div class="bg-white dark:bg-gray-800 rounded-xl p-5 shadow-sm border border-gray-100 dark:border-gray-700 transition-all hover:shadow-md fade-in-up" style="animation-delay: {{ $index * 0.08 }}s;">
                                <div class="flex items-start justify-between mb-3">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $r->user->foto ? asset('storage/' . $r->user->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($r->user->name) . '&background=random&color=fff' }}"
                                            alt="Avatar {{ $r->user->name }}" class="w-10 h-10 rounded-full object-cover shadow-sm ring-2 ring-gray-100 dark:ring-gray-700">
                                        <div>
                                            <h6 class="font-bold text-gray-900 dark:text-white text-sm">{{ $r->user->name }}</h6>
                                            <small class="text-gray-500 dark:text-gray-400 text-xs">{{ $r->created_at->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                    <div class="flex text-yellow-400 text-xs gap-0.5">
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
                        @empty
                            <div class="text-center py-8 bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700">
                                <i class="bi bi-chat-left-dots text-4xl text-gray-300 dark:text-gray-600 mb-3 block"></i>
                                <p class="text-gray-500 dark:text-gray-400 font-medium">Belum ada ulasan. Jadilah yang pertama!</p>
                            </div>
                        @endforelse
                    </div>

                    <div class="pt-4">
                        <a href="{{ route('karya.public') }}" class="flex items-center justify-center w-full py-3.5 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 font-semibold rounded-xl border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition-all shadow-sm group">
                            <i class="bi bi-arrow-left mr-2 group-hover:-translate-x-1 transition-transform"></i>Kembali ke Daftar Karya
                        </a>
                    </div>
                </div>

            </div>
        </div>

        {{-- Lightbox Modal --}}
        <div x-show="lightboxOpen" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="lightboxOpen = false"
             @keydown.escape.window="lightboxOpen = false"
             class="fixed inset-0 z-[60] flex items-center justify-center bg-black/80 backdrop-blur-sm p-4"
             style="display: none;">
            <div class="relative max-w-5xl w-full max-h-[90vh]" @click.stop>
                <button @click="lightboxOpen = false" class="absolute -top-12 right-0 text-white/80 hover:text-white transition-colors text-2xl">
                    <i class="bi bi-x-lg"></i>
                </button>
                <img src="{{ asset('storage/' . $karya->preview_karya) }}" alt="{{ $karya->judul }}" 
                     class="w-full h-auto max-h-[85vh] object-contain rounded-2xl shadow-2xl">
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
                        // Bounce animation
                        this.style.transform = 'scale(1.3)';
                        setTimeout(() => { this.style.transform = ''; }, 200);
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
                            
                            copyText.textContent = 'Disalin!';
                            copyText.classList.add('text-green-600', 'dark:text-green-400');
                            copyIcon.className = 'bi bi-check-lg text-green-600 dark:text-green-400';
                            
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