@extends('admin.layouts.app')

@section('title', 'Karya Terunggah')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1 class="page-title">Karya Terunggah</h1>
        <p class="page-subtitle">Daftar semua karya mahasiswa yang telah diterima dan diunggah</p>
    </div>
    <a href="{{ route('karya.export') }}" class="btn btn-success" style="padding: 0.5rem 1rem; border-radius: 8px;">
        <i data-feather="download" style="width: 18px; height: 18px; margin-right: 4px;"></i> Export CSV
    </a>
</div>

<div class="card-grid" style="grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));">
    @forelse ($karyas as $karya)
        <div class="dashboard-card" style="flex-direction: column; align-items: flex-start; gap: 0.5rem;">
            <div style="display: flex; align-items: center; justify-content: space-between; width: 100%; margin-bottom: 0.5rem;">
                <span class="badge badge-success">Terpublikasi</span>
                <i data-feather="check-circle" style="color: var(--success); width: 18px; height: 18px;"></i>
            </div>
            
            <h3 style="font-size: 1.1rem; font-weight: 600; color: var(--text-main); margin-bottom: 0.25rem;">
                {{ $karya->judul }}
            </h3>

            <p style="color: var(--text-muted); font-size: 0.9rem;">
                Oleh: <span style="font-weight: 600; color: var(--primary);">{{ $karya->nama_pembuat }}</span>
            </p>

            <p style="font-size: 0.8rem; color: #9CA3AF; margin-top: 0.5rem; display: flex; align-items: center; gap: 4px;">
                <i data-feather="calendar" style="width: 12px; height: 12px;"></i>
                Diunggah pada: {{ $karya->created_at->format('d M Y, H:i') }}
            </p>
        </div>
    @empty
        <div class="dashboard-card" style="grid-column: 1 / -1; justify-content: center; text-align: center; padding: 3rem;">
            <div>
                <i data-feather="folder-minus" style="width: 48px; height: 48px; color: var(--text-muted); margin-bottom: 1rem;"></i>
                <h3 style="font-size: 1.2rem; color: var(--text-main);">Belum ada karya terunggah</h3>
            </div>
        </div>
    @endforelse
</div>
@endsection