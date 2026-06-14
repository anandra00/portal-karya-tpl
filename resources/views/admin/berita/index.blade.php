@extends('admin.layouts.app')

@section('title', 'Daftar Berita')

@push('styles')
<style>
    .tabs-container {
        display: flex;
        border-bottom: 2px solid var(--border-color);
        margin-bottom: 1.5rem;
        gap: 1.5rem;
    }
    .tab-button {
        background: none;
        border: none;
        padding: 0.75rem 0.5rem;
        font-size: 1rem;
        font-weight: 600;
        color: var(--text-muted);
        cursor: pointer;
        position: relative;
        transition: var(--transition-fast);
        outline: none;
    }
    .tab-button:hover {
        color: var(--primary);
    }
    .tab-button.active {
        color: var(--primary);
    }
    .tab-button.active::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 100%;
        height: 2px;
        background-color: var(--primary);
    }
    .tab-content {
        display: none;
    }
    .tab-content.active {
        display: block;
    }
</style>
@endpush

@section('content')
<div x-data="{ activeTab: 'active' }">
    <!-- Page Header -->
    <div class="page-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h1 class="page-title">Daftar Berita</h1>
            <p class="page-subtitle">Kelola informasi dan berita terbaru program studi</p>
        </div>
        <a href="{{ route('admin.berita.create') }}" class="btn btn-primary" style="padding: 0.5rem 1rem; border-radius: 8px; display: inline-flex; align-items: center; gap: 6px;">
            <i data-feather="plus-circle" style="width: 18px; height: 18px;"></i> Tambah Berita
        </a>
    </div>

    <!-- Tabs Navigation -->
    <div class="tabs-container">
        <button class="tab-button" :class="activeTab === 'active' ? 'active' : ''" @click="activeTab = 'active'">
            <i data-feather="file-text" style="width: 16px; height: 16px; margin-right: 4px; vertical-align: middle;"></i>
            Berita Aktif ({{ count($berita) }})
        </button>
        <button class="tab-button" :class="activeTab === 'trash' ? 'active' : ''" @click="activeTab = 'trash'">
            <i data-feather="trash-2" style="width: 16px; height: 16px; margin-right: 4px; vertical-align: middle;"></i>
            Sampah ({{ count($trashed) }})
        </button>
    </div>

    <!-- Tab 1: Berita Aktif -->
    <div x-show="activeTab === 'active'">
        <div class="card-grid" style="grid-template-columns: 1fr;">
            @forelse ($berita as $item)
                <div class="dashboard-card" style="display: flex; flex-direction: row; align-items: flex-start; gap: 1.5rem; padding: 1.5rem;">
                    @if($item->gambar)
                        <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->judul }}" 
                             style="width: 200px; height: 140px; object-fit: cover; border-radius: 8px; flex-shrink: 0; box-shadow: var(--shadow-sm);">
                    @else
                        <div style="width: 200px; height: 140px; background: var(--bg-main); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: var(--text-muted); border: 1px dashed var(--border-color); flex-shrink: 0;">
                            <i data-feather="image" style="width: 24px; height: 24px;"></i>
                        </div>
                    @endif
                    
                    <div style="flex: 1; display: flex; flex-direction: column; justify-content: space-between; height: 100%;">
                        <div>
                            <h3 style="font-size: 1.25rem; font-weight: 600; color: var(--text-main); margin-bottom: 0.5rem; line-height: 1.3;">
                                {{ $item->judul }}
                            </h3>
                            
                            <div style="display: flex; align-items: center; gap: 1rem; color: var(--text-muted); font-size: 0.85rem; margin-bottom: 0.75rem;">
                                <span style="display: flex; align-items: center; gap: 4px;">
                                    <i data-feather="user" style="width: 14px; height: 14px;"></i> {{ $item->user->name ?? 'Admin' }}
                                </span>
                                <span style="display: flex; align-items: center; gap: 4px;">
                                    <i data-feather="calendar" style="width: 14px; height: 14px;"></i> {{ $item->tanggal_publikasi->translatedFormat('d F Y') }}
                                </span>
                            </div>
                            
                            <p style="color: var(--text-muted); font-size: 0.95rem; line-height: 1.5; margin-bottom: 1rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                {{ $item->excerpt }}
                            </p>
                        </div>
                        
                        <div class="action-group" style="display: flex; gap: 8px;">
                            <a href="{{ route('admin.berita.show', $item->id) }}" class="btn btn-secondary" style="padding: 0.4rem 1rem; font-size: 0.85rem; border-radius: 6px;">
                                Lihat
                            </a>
                            
                            <a href="{{ route('admin.berita.edit', $item->id) }}" class="btn btn-secondary" style="padding: 0.4rem 1rem; font-size: 0.85rem; border-radius: 6px;">
                                Edit
                            </a>
                            
                            <form action="{{ route('admin.berita.destroy', $item->id) }}" method="POST" class="delete-form" data-name="{{ $item->judul }}" style="margin: 0;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" style="padding: 0.4rem 1rem; font-size: 0.85rem; border-radius: 6px;">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="dashboard-card" style="justify-content: center; text-align: center; padding: 4rem;">
                    <div>
                        <i data-feather="file-text" style="width: 48px; height: 48px; color: var(--text-muted); margin-bottom: 1rem; opacity: 0.5;"></i>
                        <h3 style="font-size: 1.2rem; color: var(--text-main);">Belum ada berita terpublikasi</h3>
                        <p style="color: var(--text-muted); margin-top: 0.5rem; margin-bottom: 1.5rem;">Bagikan informasi terbaru tentang program studi kepada pengunjung.</p>
                        <a href="{{ route('admin.berita.create') }}" class="btn btn-primary">
                            Tambah Berita Pertama
                        </a>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Tab 2: Sampah / Terhapus -->
    <div x-show="activeTab === 'trash'">
        <div class="card-grid" style="grid-template-columns: 1fr;">
            @forelse ($trashed as $item)
                <div class="dashboard-card" style="display: flex; flex-direction: row; align-items: flex-start; gap: 1.5rem; padding: 1.5rem; border: 1px dashed var(--danger);">
                    @if($item->gambar)
                        <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->judul }}" 
                             style="width: 200px; height: 140px; object-fit: cover; border-radius: 8px; flex-shrink: 0; opacity: 0.5; box-shadow: var(--shadow-sm);">
                    @else
                        <div style="width: 200px; height: 140px; background: var(--bg-main); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: var(--text-muted); border: 1px dashed var(--border-color); flex-shrink: 0; opacity: 0.5;">
                            <i data-feather="image" style="width: 24px; height: 24px;"></i>
                        </div>
                    @endif
                    
                    <div style="flex: 1; display: flex; flex-direction: column; justify-content: space-between; height: 100%;">
                        <div>
                            <h3 style="font-size: 1.25rem; font-weight: 600; color: var(--text-main); margin-bottom: 0.5rem; line-height: 1.3; text-decoration: line-through;">
                                {{ $item->judul }}
                            </h3>
                            
                            <div style="display: flex; align-items: center; gap: 1rem; color: var(--text-muted); font-size: 0.85rem; margin-bottom: 0.75rem;">
                                <span style="display: flex; align-items: center; gap: 4px;">
                                    <i data-feather="user" style="width: 14px; height: 14px;"></i> {{ $item->user->name ?? 'Admin' }}
                                </span>
                                <span style="display: flex; align-items: center; gap: 4px;">
                                    <i data-feather="calendar" style="width: 14px; height: 14px;"></i> Dihapus pada: {{ $item->deleted_at->translatedFormat('d F Y, H:i') }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="action-group" style="display: flex; gap: 8px;">
                            <!-- Restore button -->
                            <form action="{{ route('admin.berita.restore', $item->id) }}" method="POST" style="margin: 0;">
                                @csrf
                                <button type="submit" class="btn btn-success" style="padding: 0.4rem 1rem; font-size: 0.85rem; border-radius: 6px; background-color: var(--success); color: white; display: inline-flex; align-items: center; gap: 4px;">
                                    <i data-feather="rotate-ccw" style="width: 14px; height: 14px;"></i> Pulihkan
                                </button>
                            </form>
                            
                            <!-- Force Delete Button with SweetAlert confirmation -->
                            <form action="{{ route('admin.berita.force-delete', $item->id) }}" method="POST" class="delete-form" data-name="Permanen: {{ $item->judul }}" style="margin: 0;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" style="padding: 0.4rem 1rem; font-size: 0.85rem; border-radius: 6px; display: inline-flex; align-items: center; gap: 4px;">
                                    <i data-feather="trash" style="width: 14px; height: 14px;"></i> Hapus Permanen
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="dashboard-card" style="justify-content: center; text-align: center; padding: 4rem;">
                    <div>
                        <i data-feather="trash" style="width: 48px; height: 48px; color: var(--text-muted); margin-bottom: 1rem; opacity: 0.5;"></i>
                        <h3 style="font-size: 1.2rem; color: var(--text-main);">Keranjang sampah kosong</h3>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>

@push('styles')
<style>
    @media (max-width: 768px) {
        .dashboard-card {
            flex-direction: column !important;
        }
        .dashboard-card img {
            width: 100% !important;
            height: 200px !important;
        }
    }
</style>
@endpush
@endsection