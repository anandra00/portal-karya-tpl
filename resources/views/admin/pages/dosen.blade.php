@extends('admin.layouts.app')

@section('title', 'Daftar Dosen')

@push('styles')
<style>
    .dosen-card {
        background: var(--bg-card);
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border-color);
        border-left: 5px solid var(--primary);
        display: flex;
        align-items: center;
        gap: 1.5rem;
        transition: transform var(--transition-normal), box-shadow var(--transition-normal);
    }
    
    .dosen-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-md);
    }
    
    .dosen-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid var(--bg-main);
        box-shadow: var(--shadow-sm);
    }
    
    .dosen-info {
        flex: 1;
    }
    
    .dosen-info h3 {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--text-main);
        margin-bottom: 0.25rem;
    }
    
    .dosen-info p {
        font-size: 0.9rem;
        color: var(--text-muted);
        margin-bottom: 0.5rem;
    }
    
    .dosen-actions {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }
    
    @media (max-width: 640px) {
        .dosen-card {
            flex-direction: column;
            text-align: center;
        }
        
        .dosen-actions {
            flex-direction: row;
            width: 100%;
            justify-content: center;
            margin-top: 1rem;
        }
    }
</style>
@endpush

@section('content')
<div class="page-header" style="display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h1 class="page-title">Kelola Dosen</h1>
        <p class="page-subtitle">Daftar dosen di program studi Rekayasa Perangkat Lunak SV IPB</p>
    </div>
    <a href="{{ route('dosen.create') }}" class="btn btn-primary">
        <i data-feather="plus-circle"></i> Tambah Dosen
    </a>
</div>

<div class="card-grid" style="grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));">
    @forelse ($dosens as $dosen)
        <div class="dosen-card">
            @if ($dosen->foto)
                <img src="{{ asset('storage/' . $dosen->foto) }}" class="dosen-avatar" alt="{{ $dosen->nama }}">
            @else
                <div class="dosen-avatar" style="background-color: var(--bg-main); display: flex; align-items: center; justify-content: center;">
                    <i data-feather="user" style="color: var(--text-muted); width: 40px; height: 40px;"></i>
                </div>
            @endif

            <div class="dosen-info">
                <h3>{{ $dosen->nama }}</h3>
                <p>{{ $dosen->prodi }}</p>
                <span class="badge badge-success">Aktif</span>
            </div>

            <div class="dosen-actions">
                <a href="{{ route('dosen.edit', $dosen->id) }}" class="btn btn-secondary" style="padding: 0.4rem 1rem; font-size: 0.85rem; width: 100%; justify-content: center;">
                    Edit
                </a>
                
                <form action="{{ route('dosen.destroy', $dosen->id) }}" method="POST" style="margin: 0; width: 100%;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" style="padding: 0.4rem 1rem; font-size: 0.85rem; width: 100%; justify-content: center;" onsubmit="return confirm('Yakin ingin menghapus dosen {{ $dosen->nama }}?');">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    @empty
        <div class="dashboard-card" style="grid-column: 1 / -1; justify-content: center; text-align: center; padding: 3rem;">
            <div>
                <i data-feather="users" style="width: 48px; height: 48px; color: var(--text-muted); margin-bottom: 1rem;"></i>
                <h3 style="font-size: 1.2rem; color: var(--text-main);">Belum ada data dosen</h3>
                <p style="color: var(--text-muted); margin-top: 0.5rem;">Klik tombol "Tambah Dosen" untuk menambahkan data baru.</p>
            </div>
        </div>
    @endforelse
</div>
@endsection