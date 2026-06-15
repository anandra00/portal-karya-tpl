@extends('admin.layouts.app')

@section('title', 'Validasi Konten')

@section('content')
<div class="page-header" style="display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h1 class="page-title">Validasi Konten</h1>
        <p class="page-subtitle">Daftar karya mahasiswa yang menunggu validasi</p>
    </div>
</div>

<div class="form-card" style="max-width: 100%;">
    <div style="display: flex; flex-direction: column; gap: 1rem;">
        @forelse ($karyas as $karya)
            <div class="flex-responsive" style="padding: 1.5rem; border: 1px solid var(--border-color); border-radius: 8px; background: var(--bg-main); transition: transform 0.2s, box-shadow 0.2s;">
                <div style="display: flex; align-items: center; gap: 1.5rem;" class="word-break-all">
                    <div style="width: 50px; height: 50px; border-radius: 12px; background: rgba(37, 99, 235, 0.1); color: var(--primary); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <i data-feather="file-text" style="width: 24px; height: 24px;"></i>
                    </div>
                    <div>
                        <h4 style="font-size: 1.1rem; font-weight: 600; margin: 0 0 0.25rem 0; color: var(--text-main);">{{ $karya->judul }}</h4>
                        <span style="font-size: 0.9rem; color: var(--text-muted); display: flex; align-items: center; gap: 6px;">
                            <i data-feather="users" style="width: 14px; height: 14px;"></i> {{ $karya->tim_pembuat }}
                        </span>
                    </div>
                </div>
                <div class="action-group">
                    <a href="{{ route('karya.form', $karya->id) }}" class="btn btn-primary" style="padding: 0.5rem 1.5rem;">
                        <i data-feather="check-square"></i> Validasi
                    </a>
                </div>
            </div>
        @empty
            <div style="text-align: center; padding: 4rem 2rem; color: var(--text-muted);">
                <i data-feather="inbox" style="width: 64px; height: 64px; margin-bottom: 1rem; color: #cbd5e1;"></i>
                <h3 style="font-size: 1.25rem; font-weight: 600; color: var(--text-main); margin-bottom: 0.5rem;">Tidak ada antrean</h3>
                <p style="margin: 0;">Semua karya telah selesai divalidasi.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection