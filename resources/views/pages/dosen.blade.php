@extends('layouts.app')

@section('title', 'Dosen')



@section('hero')
@include('partials.hero')
@endsection

@section('content')
<main class="dosen-section info-section py-5">
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-lg-10">

                <header class="info-header mb-5 text-center">
                    <h2 class="fw-bold" style="color: var(--warna-hero);">Dosen Teknologi Rekayasa Perangkat Lunak SV IPB</h2>
                    <hr>
                </header>

                <div class="row">
                    @foreach ($dosens as $dosen)
                        <div class="col-12 col-md-6 col-lg-4 mb-4 fade-in-up">
                            <div class="card premium-card h-100 border-0 text-center">
                                <div class="card-body d-flex flex-column align-items-center p-4">

                                    @if ($dosen->foto)
                                        <img src="{{ asset('storage/' . $dosen->foto) }}" 
                                             class="dosen-img rounded-circle mb-3 premium-shadow"
                                             alt="Foto {{ $dosen->nama }}">
                                    @else
                                        <img src="{{ asset('images/default-user.png') }}"
                                             class="dosen-img rounded-circle mb-3 premium-shadow"
                                             alt="Default Foto">
                                    @endif

                                    <h5 class="card-title fw-bold mb-1" style="color: var(--warna-hero);">{{ $dosen->nama }}</h5>
                                    <p class="text-muted small mb-3">{{ $dosen->prodi }}</p>

                                    <span class="badge premium-badge mt-auto">
                                        {{ $dosen->status ?? 'Aktif' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>

    </div>
</main>
@endsection
