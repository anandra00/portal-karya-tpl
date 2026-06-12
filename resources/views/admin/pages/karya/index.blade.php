@extends('admin.layouts.app')

@section('title', 'Kelola Karya')

@section('content')
<div class="page-header" style="display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h1 class="page-title">Kelola Karya</h1>
        <p class="page-subtitle">Daftar karya mahasiswa yang telah divalidasi</p>
    </div>
    <a href="{{ route('karya.create') }}" class="btn btn-primary">
        <i data-feather="plus-circle"></i> Tambah Karya
    </a>
</div>

<div class="row g-4 mt-2">
    {{-- Karya Disetujui --}}
    <div class="col-md-6">
        <div class="dashboard-card" style="display: block; border-top: 4px solid var(--success);">
            <h3 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1.5rem; color: var(--success); display: flex; align-items: center; gap: 8px;">
                <i data-feather="check-circle"></i> Karya Disetujui
            </h3>

            <div style="display: flex; flex-direction: column; gap: 1rem;">
                @forelse($accepted as $a)
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem; border: 1px solid var(--border-color); border-radius: 8px; background: var(--bg-main);">
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <div style="width: 40px; height: 40px; border-radius: 8px; background: rgba(16, 185, 129, 0.1); color: var(--success); display: flex; align-items: center; justify-content: center;">
                                <i data-feather="file-text"></i>
                            </div>
                            <div>
                                <h4 style="font-size: 1rem; font-weight: 600; margin: 0; color: var(--text-main);">{{ $a->judul }}</h4>
                                <span style="font-size: 0.85rem; color: var(--text-muted);">{{ $a->user->name ?? 'Anonim' }}</span>
                            </div>
                        </div>
                        <a href="{{ route('karya.show', $a->id) }}" class="btn btn-secondary" style="font-size: 0.85rem; padding: 0.4rem 1rem;">
                            Lihat
                        </a>
                    </div>
                @empty
                    <div style="text-align: center; padding: 2rem; color: var(--text-muted);">
                        <p style="margin: 0;">Tidak ada karya disetujui.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Karya Ditolak --}}
    <div class="col-md-6">
        <div class="dashboard-card" style="display: block; border-top: 4px solid var(--danger);">
            <h3 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1.5rem; color: var(--danger); display: flex; align-items: center; gap: 8px;">
                <i data-feather="x-circle"></i> Karya Ditolak
            </h3>

            <div style="display: flex; flex-direction: column; gap: 1rem;">
                @forelse($rejected as $r)
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem; border: 1px solid var(--border-color); border-radius: 8px; background: var(--bg-main);">
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <div style="width: 40px; height: 40px; border-radius: 8px; background: rgba(239, 68, 68, 0.1); color: var(--danger); display: flex; align-items: center; justify-content: center;">
                                <i data-feather="file-text"></i>
                            </div>
                            <div>
                                <h4 style="font-size: 1rem; font-weight: 600; margin: 0; color: var(--text-main);">{{ $r->judul }}</h4>
                                <span style="font-size: 0.85rem; color: var(--text-muted);">{{ $r->user->name ?? 'Anonim' }}</span>
                            </div>
                        </div>
                        <a href="{{ route('karya.show', $r->id) }}" class="btn btn-secondary" style="font-size: 0.85rem; padding: 0.4rem 1rem;">
                            Lihat
                        </a>
                    </div>
                @empty
                    <div style="text-align: center; padding: 2rem; color: var(--text-muted);">
                        <p style="margin: 0;">Tidak ada karya ditolak.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection