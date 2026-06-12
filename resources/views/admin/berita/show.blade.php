@extends('admin.layouts.app')

@section('title', 'Detail Berita')

@section('content')
<div class="page-header" style="display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h1 class="page-title">Detail Berita</h1>
        <p class="page-subtitle">Pratinjau konten berita yang dipublikasikan</p>
    </div>
    <a href="{{ route('admin.berita.index') }}" class="btn btn-secondary">
        <i data-feather="arrow-left"></i> Kembali
    </a>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="dashboard-card" style="display: block;">
            <h2 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 1rem; color: var(--text-main); line-height: 1.3;">
                {{ $berita->judul }}
            </h2>

            <div style="display: flex; align-items: center; gap: 1.5rem; margin-bottom: 1.5rem; color: var(--text-muted); font-size: 0.9rem; padding-bottom: 1.5rem; border-bottom: 1px solid var(--border-color);">
                <span style="display: flex; align-items: center; gap: 6px;">
                    <i data-feather="user" style="width: 16px; height: 16px;"></i> Penulis: ID {{ $berita->user_id }}
                </span>
                <span style="display: flex; align-items: center; gap: 6px;">
                    <i data-feather="calendar" style="width: 16px; height: 16px;"></i> Dipublikasikan: {{ \Carbon\Carbon::parse($berita->tanggal_publikasi)->translatedFormat('d F Y') }}
                </span>
            </div>

            <div style="font-size: 1.05rem; line-height: 1.8; color: var(--text-main); white-space: pre-wrap;">{{ $berita->isi }}</div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="dashboard-card" style="display: block;">
            <h3 style="font-size: 1.1rem; font-weight: 600; margin-bottom: 1rem; color: var(--text-main);">Gambar Berita</h3>
            @if($berita->gambar)
                <img src="{{ asset('storage/' . $berita->gambar) }}" alt="Gambar Berita" style="width: 100%; height: auto; border-radius: 8px; border: 1px solid var(--border-color); margin-bottom: 1.5rem;">
            @else
                <div style="width: 100%; height: 200px; background: var(--bg-main); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: var(--text-muted); border: 1px dashed var(--border-color); margin-bottom: 1.5rem;">
                    <div style="text-align: center;">
                        <i data-feather="image" style="width: 32px; height: 32px; margin-bottom: 8px;"></i>
                        <p style="margin: 0; font-size: 0.9rem;">Tidak ada gambar</p>
                    </div>
                </div>
            @endif

            <a href="{{ route('admin.berita.edit', $berita->id) }}" class="btn btn-primary" style="width: 100%; justify-content: center;">
                <i data-feather="edit"></i> Edit Berita Ini
            </a>
        </div>
    </div>
</div>
@endsection
