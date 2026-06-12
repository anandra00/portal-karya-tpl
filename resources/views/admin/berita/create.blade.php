@extends('admin.layouts.app')

@section('title', 'Tambah Berita')

@section('content')
<div class="page-header" style="display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h1 class="page-title">Tambah Berita</h1>
        <p class="page-subtitle">Formulir penambahan berita dan informasi terbaru</p>
    </div>
    <a href="{{ route('admin.berita.index') }}" class="btn btn-secondary">
        <i data-feather="arrow-left"></i> Kembali
    </a>
</div>

<div class="dashboard-card" style="display: block; max-width: 800px;">
    @if(session('success'))
        <div style="background-color: #D1FAE5; color: #065F46; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; border: 1px solid #34D399; display: flex; align-items: center; gap: 8px;">
            <i data-feather="check-circle" style="width: 18px; height: 18px;"></i> {{ session('success') }}
        </div>
    @elseif(session('error'))
        <div style="background-color: #FEE2E2; color: #991B1B; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; border: 1px solid #F87171; display: flex; align-items: center; gap: 8px;">
            <i data-feather="alert-circle" style="width: 18px; height: 18px;"></i> {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div style="margin-bottom: 1.5rem;">
            <label for="judul" style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: var(--text-main);">Judul Berita <span style="color: var(--danger);">*</span></label>
            <input type="text" id="judul" name="judul" required placeholder="Masukkan judul berita" class="form-control">
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label for="tanggal_publikasi" style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: var(--text-main);">Tanggal Publikasi <span style="color: var(--danger);">*</span></label>
            <input type="date" id="tanggal_publikasi" name="tanggal_publikasi" required class="form-control">
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label for="gambar" style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: var(--text-main);">Gambar Berita</label>
            <input type="file" id="gambar" name="gambar" accept="image/*" class="form-control">
            <small style="color: var(--text-muted); display: block; margin-top: 0.25rem;">Format: JPG, PNG. Rekomendasi rasio 16:9.</small>
        </div>

        <div style="margin-bottom: 2rem;">
            <label for="isi" style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: var(--text-main);">Isi Berita <span style="color: var(--danger);">*</span></label>
            <textarea id="isi" name="isi" required rows="10" placeholder="Masukkan konten berita selengkapnya..." class="form-control" style="resize: vertical;"></textarea>
        </div>

        <input type="hidden" name="user_id" value="{{ auth()->id() }}">

        <div class="action-group">
            <button type="submit" class="btn btn-primary">
                <i data-feather="save"></i> Simpan Berita
            </button>
            <a href="{{ route('admin.berita.index') }}" class="btn btn-secondary">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
