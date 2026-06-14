@extends('admin.layouts.app')

@section('title', 'Daftar Ajuan Karya')

@section('content')
<div class="page-header">
    <h1 class="page-title">Daftar Ajuan Karya</h1>
    <p class="page-subtitle">Karya yang berstatus submission menunggu validasi.</p>
</div>

<div class="card-grid" style="grid-template-columns: repeat(auto-fill, minmax(min(100%, 350px), 1fr));">
    @forelse ($karyas as $karya)
        <div class="dashboard-card" style="flex-direction: column; align-items: flex-start; position: relative; gap: 1rem;">
            <div style="width: 100%;" class="word-break-all">
                <h4 style="font-size: 1.15rem; font-weight: 600; margin-bottom: 0.5rem; color: var(--text-main);">{{ $karya->judul }}</h4>
                <p style="color: var(--text-muted); font-size: 0.95rem;">
                    Oleh: <strong style="color: var(--primary);">{{ $karya->tim_pembuat }}</strong>
                </p>
            </div>
            
            <div style="display: flex; gap: 0.75rem; width: 100%; margin-top: 0.5rem;">
                <form action="{{ route('karya.destroy', $karya->id) }}" method="post" class="delete-form" data-name="{{ $karya->judul }}" style="margin: 0; flex: 1;">
                    @csrf
                    @method("delete")
                    <button type="submit" class="btn btn-danger" style="width: 100%; justify-content: center;">
                        <i data-feather="trash-2" style="width: 16px; height: 16px;"></i>
                        Hapus
                    </button>
                </form>
                <a href="{{ route('karya.show', $karya->id) }}" class="btn btn-primary" style="flex: 1; justify-content: center;">
                    <i data-feather="eye" style="width: 16px; height: 16px;"></i>
                    Lihat
                </a> 
            </div>
        </div>
    @empty
        <div class="dashboard-card" style="grid-column: 1 / -1; justify-content: center; text-align: center; padding: 3rem;">
            <div>
                <i data-feather="inbox" style="width: 48px; height: 48px; color: var(--text-muted); margin-bottom: 1rem;"></i>
                <h3 style="font-size: 1.2rem; color: var(--text-main);">Belum ada ajuan karya</h3>
                <p style="color: var(--text-muted); margin-top: 0.5rem;">Karya yang diunggah akan muncul di sini.</p>
            </div>
        </div>
    @endforelse
</div>
@endsection