@extends('layouts.app')

@section('title', 'Detail Karya')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/detailkarya.css') }}">
@endpush

@section('hero')
@include('partials.hero')
@endsection

@section('content')
    <main class="detail-section py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">

                    <div class="row g-4">

                        {{-- Main Content --}}
                        <div class="col-lg-8 fade-in-up">
                            {{-- Author Card --}}
                            <div class="card p-3 mb-4 author-card">
                                <div class="d-flex align-items-center flex-wrap">

                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($karya->tim_pembuat) }}&background=random&color=fff&size=80"
                                        alt="Avatar Penulis" class="avatar rounded-circle" width="80" height="80">

                                    <div class="ms-3">
                                        <h5 class="mb-0 fw-bold">{{$karya->tim_pembuat}}</h5>
                                    </div>
                                    <div class="rating-box text-end ms-auto">
                                        @php
                                            $avgRating = $karya->reviews->avg('rating') ?? 0;
                                            $reviewCount = $karya->reviews->count();
                                        @endphp

                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= floor($avgRating))
                                                <i class="bi bi-star-fill text-warning"></i>
                                            @elseif ($i <= ceil($avgRating) && $avgRating - floor($avgRating) >= 0.5)
                                                <i class="bi bi-star-half text-warning"></i>
                                            @else
                                                <i class="bi bi-star text-warning"></i>
                                            @endif
                                        @endfor

                                        <small class="mt-1 text-muted d-block">
                                            {{ number_format($avgRating, 1) }} ({{ $reviewCount }} ulasan)
                                        </small>
                                    </div>
                                </div>
                            </div>

                            {{-- Project Card --}}
                            <div class="card p-4 project-card">
                                <h2 class="h4 fw-bold">{{ $karya->judul }}</h2>
                                <img src="{{ asset('storage/' . $karya->preview_karya) }}" alt="Screenshot Proyek"
                                    class="img-fluid rounded my-3">

                                <h5 class="fw-bold">{{ $karya->deskripsi }}</h5>

                                @if ($karya->link_pengumpulan)
                                    <a href="{{ $karya->link_pengumpulan }}" target="_blank"
                                        class="btn btn-tpl btn-lg mt-4 w-100">
                                        <i class="bi bi-box-arrow-up-right me-2"></i> Kunjungi Karya Ini
                                    </a>
                                @endif

                            </div>
                        </div>

                        {{-- Sidebar --}}
                        <div class="col-lg-4 fade-in-up">
                            {{-- Feedback Form --}}
                            <div class="card p-3 mb-4">
                                <form action="{{ route('review.store') }}" method="post">
                                    @csrf
                                    @method('post')
                                    <h5 class="fw-bold">Tulis Umpan Balik</h5>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="stars-input text-muted fs-4">
                                            <i class="bi bi-star" data-value="1"></i>
                                            <i class="bi bi-star" data-value="2"></i>
                                            <i class="bi bi-star" data-value="3"></i>
                                            <i class="bi bi-star" data-value="4"></i>
                                            <i class="bi bi-star" data-value="5"></i>
                                        </div>
                                        <span class="fw-bold text-muted" id="rating-display">N/A</span>
                                    </div>
                                    <textarea name="comment" class="form-control my-2" rows="5"
                                        placeholder="Tulis reviewmu disini..."></textarea>
                                    <input type="hidden" name="rating" id="rating-value" value="0">
                                    <input type="hidden" name="karya_id" value="{{ $karya->id }}">
                                    <button class="btn btn-tpl w-100" type="submit">Kirim</button>
                                </form>
                            </div>

                            {{-- Review List --}}
                            @foreach ($review as $r)
                                <div class="card p-3 mb-3 feedback-card">
                                    <div class="d-flex align-items-center mb-2">

                                        <img src="{{ $r->user->foto ? asset('storage/' . $r->user->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($r->user->name) . '&background=random&color=fff' }}"
                                            alt="Avatar {{ $r->user->name }}" class="avatar-sm rounded-circle" width="50"
                                            height="50" style="object-fit: cover;">

                                        <div class="ms-3">
                                            <h6 class="mb-0 fw-bold">{{ $r->user->name }}</h6>
                                            <small class="text-muted">{{ $r->created_at->diffForHumans() }}</small>
                                        </div>
                                        <div class="stars-display ms-auto text-warning">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= $r->rating)
                                                    <i class="bi bi-star-fill"></i>
                                                @else
                                                    <i class="bi bi-star text-muted"></i>
                                                @endif
                                            @endfor
                                        </div>

                                    </div>
                                    <p class="mb-0 small">{{ $r->comment }}</p>
                                </div>
                            @endforeach

                            <div class="text-center mt-4 mb-4">
                                <a href="{{ route('home') }}" class="btn btn-secondary btn-lg">
                                    <i class="bi bi-arrow-left me-2"></i>Kembali ke Home
                                </a>
                            </div>
                        </div>
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