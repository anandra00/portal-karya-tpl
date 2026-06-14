@extends('admin.layouts.app')

@section('title', 'Kelola Karya')

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
<div x-data="{ search: '', category: '', status: '', activeTab: 'active' }">
    <!-- Page Header -->
    <div class="page-header d-flex justify-content-between align-items-center" style="flex-wrap: wrap; gap: 1rem;">
        <div>
            <h1 class="page-title">Kelola Karya</h1>
            <p class="page-subtitle">Daftar seluruh karya mahasiswa beserta status verifikasinya</p>
        </div>
        <div style="display: flex; gap: 8px;">
            <a href="{{ route('karya.create') }}" class="btn btn-primary" style="padding: 0.5rem 1rem; border-radius: 8px; display: inline-flex; align-items: center; gap: 6px;">
                <i data-feather="plus" style="width: 18px; height: 18px;"></i> Tambah Karya
            </a>
            <a href="{{ route('karya.export') }}" class="btn btn-success" style="padding: 0.5rem 1rem; border-radius: 8px; display: inline-flex; align-items: center; gap: 6px;">
                <i data-feather="download" style="width: 18px; height: 18px;"></i> Export Excel
            </a>
        </div>
    </div>

    <!-- Tabs Navigation -->
    <div class="tabs-container">
        <button class="tab-button" :class="activeTab === 'active' ? 'active' : ''" @click="activeTab = 'active'">
            <i data-feather="folder" style="width: 16px; height: 16px; margin-right: 4px; vertical-align: middle;"></i>
            Karya Aktif ({{ count($karyas) }})
        </button>
        <button class="tab-button" :class="activeTab === 'trash' ? 'active' : ''" @click="activeTab = 'trash'">
            <i data-feather="trash-2" style="width: 16px; height: 16px; margin-right: 4px; vertical-align: middle;"></i>
            Sampah ({{ count($trashed) }})
        </button>
    </div>

    <!-- Tab 1: Karya Aktif -->
    <div x-show="activeTab === 'active'">
        <!-- Filter & Search Bar -->
        <div style="display: flex; gap: 1rem; margin-bottom: 1.5rem; flex-wrap: wrap; background: var(--bg-card); padding: 1rem; border-radius: 12px; border: 1px solid var(--border-color); box-shadow: var(--shadow-sm);">
            <div style="flex: 1; min-width: 200px; position: relative;">
                <i data-feather="search" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); width: 16px; height: 16px; color: var(--text-muted); pointer-events: none;"></i>
                <input type="text" x-model="search" placeholder="Cari judul atau pembuat karya..." class="form-control" style="padding-left: 36px; border-radius: 8px; width: 100%;">
            </div>
            <div style="width: 180px;">
                <select x-model="category" class="form-control" style="border-radius: 8px; width: 100%;">
                    <option value="">Semua Kategori</option>
                    @foreach(\Modules\Karya\Models\Kategori::all() as $cat)
                        <option value="{{ $cat->nama }}">{{ $cat->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div style="width: 180px;">
                <select x-model="status" class="form-control" style="border-radius: 8px; width: 100%;">
                    <option value="">Semua Status</option>
                    <option value="accepted">Terpublikasi</option>
                    <option value="rejected">Ditolak</option>
                    <option value="submission">Pending</option>
                </select>
            </div>
        </div>

        <!-- Cards Grid -->
        <div class="card-grid" style="grid-template-columns: repeat(auto-fill, minmax(min(100%, 300px), 1fr));">
            @forelse ($karyas as $karya)
                <div class="dashboard-card active-karya-card" 
                     x-show="
                        (search === '' || '{{ strtolower(addslashes($karya->judul)) }}'.includes(search.toLowerCase()) || '{{ strtolower(addslashes($karya->tim_pembuat)) }}'.includes(search.toLowerCase())) &&
                        (category === '' || '{{ $karya->kategori }}' === category) &&
                        (status === '' || '{{ $karya->status_validasi }}' === status)
                     "
                     style="flex-direction: column; align-items: flex-start; gap: 0.5rem; padding: 1.5rem; border: 1px solid var(--border-color); position: relative; display: flex; justify-content: space-between; height: 100%;">
                    
                    <div style="width: 100%;">
                        <div style="display: flex; align-items: center; justify-content: space-between; width: 100%; margin-bottom: 0.75rem;">
                            @if($karya->status_validasi === 'accepted')
                                <span class="badge badge-success" style="background-color: rgba(16, 185, 129, 0.1); color: var(--success); font-weight: 600; padding: 0.25rem 0.5rem; border-radius: 6px;">Terpublikasi</span>
                                <i data-feather="check-circle" style="color: var(--success); width: 18px; height: 18px;"></i>
                            @elseif($karya->status_validasi === 'rejected')
                                <span class="badge badge-danger" style="background-color: rgba(239, 68, 68, 0.1); color: var(--danger); font-weight: 600; padding: 0.25rem 0.5rem; border-radius: 6px;">Ditolak</span>
                                <i data-feather="x-circle" style="color: var(--danger); width: 18px; height: 18px;"></i>
                            @else
                                <span class="badge badge-warning" style="background-color: rgba(245, 158, 11, 0.1); color: var(--warning); font-weight: 600; padding: 0.25rem 0.5rem; border-radius: 6px;">Pending</span>
                                <i data-feather="clock" style="color: var(--warning); width: 18px; height: 18px;"></i>
                            @endif
                        </div>
                        
                        <h3 style="font-size: 1.15rem; font-weight: 700; color: var(--text-main); margin-bottom: 0.5rem; line-height: 1.4;" class="word-break-all">
                            {{ $karya->judul }}
                        </h3>

                        <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 0.5rem;" class="word-break-all">
                            Oleh: <span style="font-weight: 600; color: var(--primary);">{{ $karya->tim_pembuat }}</span>
                        </p>

                        <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 0.5rem; display: inline-flex; align-items: center; gap: 4px;">
                            <span style="background: var(--bg-main); padding: 2px 8px; border-radius: 4px; font-weight: 500; font-size: 0.75rem;">
                                {{ $karya->kategori }}
                            </span>
                            <span style="background: var(--bg-main); padding: 2px 8px; border-radius: 4px; font-weight: 500; font-size: 0.75rem;">
                                Tahun {{ $karya->tahun }}
                            </span>
                        </p>
                    </div>

                    <div style="width: 100%;">
                        <p style="font-size: 0.8rem; color: #9CA3AF; margin-top: 0.75rem; display: flex; align-items: center; gap: 4px; border-top: 1px dashed var(--border-color); padding-top: 0.75rem;">
                            <i data-feather="calendar" style="width: 12px; height: 12px;"></i>
                            Diunggah pada: {{ $karya->created_at->format('d M Y, H:i') }}
                        </p>

                        <div style="display: flex; gap: 8px; width: 100%; margin-top: 0.75rem;">
                            @if($karya->status_validasi === 'accepted')
                                <a href="{{ route('karya.public.show', $karya->id) }}" target="_blank" class="btn btn-secondary" style="flex: 1; padding: 0.4rem 0.8rem; font-size: 0.85rem; justify-content: center; border-radius: 6px; display: inline-flex; align-items: center; gap: 4px;">
                                    <i data-feather="external-link" style="width: 14px; height: 14px;"></i> Lihat Web
                                </a>
                            @else
                                <a href="{{ route('karya.form', $karya->id) }}" class="btn btn-secondary" style="flex: 1; padding: 0.4rem 0.8rem; font-size: 0.85rem; justify-content: center; border-radius: 6px; display: inline-flex; align-items: center; gap: 4px; background-color: rgba(79, 70, 229, 0.1); color: var(--primary);">
                                    <i data-feather="check-square" style="width: 14px; height: 14px;"></i> Validasi
                                </a>
                            @endif
                            
                            <form action="{{ route('karya.destroy', $karya->id) }}" method="POST" class="delete-form" data-name="{{ $karya->judul }}" style="display: inline-block; margin: 0;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" style="padding: 0.4rem 0.6rem; border-radius: 6px; height: 100%; display: inline-flex; align-items: center; justify-content: center;" title="Pindahkan ke Sampah">
                                    <i data-feather="trash-2" style="width: 14px; height: 14px;"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="dashboard-card" style="grid-column: 1 / -1; justify-content: center; text-align: center; padding: 3rem;">
                    <div>
                        <i data-feather="folder-minus" style="width: 48px; height: 48px; color: var(--text-muted); margin-bottom: 1rem;"></i>
                        <h3 style="font-size: 1.2rem; color: var(--text-main);">Belum ada karya aktif</h3>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Tab 2: Sampah / Terhapus -->
    <div x-show="activeTab === 'trash'">
        <div class="card-grid" style="grid-template-columns: repeat(auto-fill, minmax(min(100%, 300px), 1fr));">
            @forelse ($trashed as $karya)
                <div class="dashboard-card" style="flex-direction: column; align-items: flex-start; gap: 0.5rem; padding: 1.5rem; border: 1px dashed var(--danger); position: relative; display: flex; justify-content: space-between; height: 100%;">
                    <div style="width: 100%;">
                        <div style="display: flex; align-items: center; justify-content: space-between; width: 100%; margin-bottom: 0.75rem;">
                            <span class="badge" style="background-color: rgba(239, 68, 68, 0.1); color: var(--danger); font-weight: 600; padding: 0.25rem 0.5rem; border-radius: 6px;">Terhapus</span>
                            <i data-feather="trash-2" style="color: var(--danger); width: 18px; height: 18px;"></i>
                        </div>
                        
                        <h3 style="font-size: 1.15rem; font-weight: 700; color: var(--text-main); margin-bottom: 0.5rem; line-height: 1.4;" class="word-break-all">
                            {{ $karya->judul }}
                        </h3>

                        <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 0.5rem;" class="word-break-all">
                            Oleh: <span style="font-weight: 600; color: var(--primary);">{{ $karya->tim_pembuat }}</span>
                        </p>

                        <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 0.5rem; display: inline-flex; align-items: center; gap: 4px;">
                            <span style="background: var(--bg-main); padding: 2px 8px; border-radius: 4px; font-weight: 500; font-size: 0.75rem;">
                                {{ $karya->kategori }}
                            </span>
                        </p>
                    </div>

                    <div style="width: 100%;">
                        <p style="font-size: 0.8rem; color: #9CA3AF; margin-top: 0.75rem; display: flex; align-items: center; gap: 4px; border-top: 1px dashed var(--border-color); padding-top: 0.75rem;">
                            <i data-feather="calendar" style="width: 12px; height: 12px;"></i>
                            Dihapus pada: {{ $karya->deleted_at->format('d M Y, H:i') }}
                        </p>

                        <div style="display: flex; gap: 8px; width: 100%; margin-top: 0.75rem;">
                            <!-- Restore button -->
                            <form action="{{ route('admin.karya.restore', $karya->id) }}" method="POST" style="flex: 1; margin: 0;">
                                @csrf
                                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.4rem 0.8rem; font-size: 0.85rem; justify-content: center; border-radius: 6px; display: inline-flex; align-items: center; gap: 4px; background-color: var(--success); color: white;">
                                    <i data-feather="rotate-ccw" style="width: 14px; height: 14px;"></i> Pulihkan
                                </button>
                            </form>
                            
                            <!-- Force Delete Button with SweetAlert confirmation -->
                            <form action="{{ route('admin.karya.force-delete', $karya->id) }}" method="POST" class="delete-form" data-name="Permanen: {{ $karya->judul }}" style="display: inline-block; margin: 0;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" style="padding: 0.4rem 0.8rem; border-radius: 6px; height: 100%; display: inline-flex; align-items: center; justify-content: center; gap: 4px;" title="Hapus Permanen">
                                    <i data-feather="trash" style="width: 14px; height: 14px;"></i> Hapus Permanen
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="dashboard-card" style="grid-column: 1 / -1; justify-content: center; text-align: center; padding: 4rem;">
                    <div>
                        <i data-feather="trash" style="width: 48px; height: 48px; color: var(--text-muted); margin-bottom: 1rem; opacity: 0.5;"></i>
                        <h3 style="font-size: 1.2rem; color: var(--text-main);">Keranjang sampah kosong</h3>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection