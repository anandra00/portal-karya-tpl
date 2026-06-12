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
@include('partials.hero')
@endsection

@section('content')
    <main class="py-20 bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- Main Content --}}
                <div class="lg:col-span-2 space-y-8 fade-in-up">
                    {{-- Author Card --}}
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 flex flex-col sm:flex-row items-center sm:items-start justify-between gap-6">
                        <div class="flex items-center gap-4">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($karya->tim_pembuat) }}&background=random&color=fff&size=80"
                                alt="Avatar Penulis" class="w-20 h-20 rounded-full shadow-md">
                            <div>
                                <h5 class="text-xl font-bold text-gray-900 dark:text-white">{{$karya->tim_pembuat}}</h5>
                                <span class="text-sm text-indigo-600 dark:text-indigo-400 font-medium">Tim Pembuat</span>
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
                                        <i class="bi bi-star"></i>
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
                        
                        <div class="rounded-2xl overflow-hidden mb-8 shadow-md border border-gray-100 dark:border-gray-700 bg-gray-100 dark:bg-gray-900">
                            <img src="{{ asset('storage/' . $karya->preview_karya) }}" alt="Screenshot Proyek"
                                class="w-full h-auto object-cover max-h-[600px]">
                        </div>

                        <div class="prose prose-lg dark:prose-invert max-w-none text-gray-700 dark:text-gray-300 font-medium mb-10">
                            {{ $karya->deskripsi }}
                        </div>

                        @if ($karya->link_pengumpulan)
                            <a href="{{ $karya->link_pengumpulan }}" target="_blank"
                                class="flex items-center justify-center w-full py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-md hover:shadow-lg transition-all text-lg">
                                <i class="bi bi-box-arrow-up-right mr-3"></i> Kunjungi Karya Ini
                            </a>
                        @endif
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
                            
                            <div class="flex justify-between items-center mb-4 bg-gray-50 dark:bg-gray-900 p-3 rounded-lg border border-gray-200 dark:border-gray-700">
                                <div class="stars-input text-2xl text-gray-300 dark:text-gray-600 flex gap-1 cursor-pointer">
                                    <i class="bi bi-star hover:text-yellow-400 transition-colors" data-value="1"></i>
                                    <i class="bi bi-star hover:text-yellow-400 transition-colors" data-value="2"></i>
                                    <i class="bi bi-star hover:text-yellow-400 transition-colors" data-value="3"></i>
                                    <i class="bi bi-star hover:text-yellow-400 transition-colors" data-value="4"></i>
                                    <i class="bi bi-star hover:text-yellow-400 transition-colors" data-value="5"></i>
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
            document.querySelectorAll('.stars-input i').forEach(star => {

                star.addEventListener('click', function () {

                    const value = this.getAttribute('data-value');

                    // isi hidden rating
                    document.getElementById('rating-value').value = value;
                    document.getElementById('rating-display').textContent = value + '.0';

                    // reset semua bintang
                    document.querySelectorAll('.stars-input i').forEach(s => {
                        s.classList.remove('bi-star-fill');
                        s.classList.add('bi-star');
                    });

                    // isi bintang sampai value
                    for (let i = 1; i <= value; i++) {
                        let target = document.querySelector(`.stars-input i[data-value="${i}"]`);
                        if (target) {
                            target.classList.add('bi-star-fill');
                            target.classList.remove('bi-star');
                        }
                    }
                });
            });
        </script>
    @endpush

@endsection