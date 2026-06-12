@extends('layouts.app')

@section('title', 'Mata Kuliah - Portal TPL SVIPB')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/matkul.css') }}">
@endpush

@section('hero')
@include('partials.hero')
@endsection

@section('content')
<main class="info-section py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <header class="info-header mb-5 text-center">
                    <h2 class="fw-bold" style="color: var(--warna-hero);">Mata Kuliah Teknologi Rekayasa Perangkat Lunak SV IPB</h2>
                    <hr>
                </header>

                @php
                    $semesters = [
                        1 => $semester1, 2 => $semester2, 3 => $semester3, 4 => $semester4,
                        5 => $semester5, 6 => $semester6, 7 => $semester7, 8 => $semester8,
                    ];
                @endphp

                @foreach(array_chunk(range(1, 8), 2) as $pair)
                <div class="row">
                    @foreach($pair as $sem)
                    <div class="col-lg-6 mb-4 fade-in-up">
                        <div class="card premium-card semester-card">
                            <div class="card-header">
                                <h3>Semester {{ $sem }}</h3>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-striped mb-0">
                                        <thead>
                                            <tr><th>Kode</th><th>Mata Kuliah</th><th>SKS</th></tr>
                                        </thead>
                                        <tbody>
                                            @forelse($semesters[$sem] as $mk)
                                            <tr>
                                                <td>{{ $mk->kode_matkul }}</td>
                                                <td>{{ $mk->nama_matkul }}</td>
                                                <td>{{ $mk->sks_teori + $mk->sks_praktik }}({{ $mk->sks_teori }}-{{ $mk->sks_praktik }})</td>
                                            </tr>
                                            @empty
                                            <tr><td colspan="3" class="text-center text-muted">Belum ada data</td></tr>
                                            @endforelse
                                            <tr class="table-total">
                                                <td>Total</td>
                                                <td></td>
                                                <td>
                                                    {{ $semesters[$sem]->sum(function($mk) { 
                                                        return (int)$mk->sks_teori + (int)$mk->sks_praktik; 
                                                    }) }}
                                                    ({{ $semesters[$sem]->sum('sks_teori') }}-{{ $semesters[$sem]->sum('sks_praktik') }})
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endforeach

            </div>
        </div>
    </div>
</main>
@endsection