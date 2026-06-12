@extends('admin.layouts.app')

@section('title', 'Edit Berita')

@section('content')
<div class="page-header" style="display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h1 class="page-title">Edit Berita</h1>
        <p class="page-subtitle">Perbarui konten informasi atau berita</p>
    </div>
    <a href="{{ route('admin.berita.index') }}" class="btn btn-secondary">
        <i data-feather="arrow-left"></i> Kembali
    </a>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="dashboard-card" style="display: block;">
            <form action="{{ route('admin.berita.update', $berita->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div style="margin-bottom: 1.5rem;">
                    <label for="judul" style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: var(--text-main);">Judul Berita <span style="color: var(--danger);">*</span></label>
                    <input type="text" id="judul" name="judul" value="{{ $berita->judul }}" required class="form-control">
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label for="tanggal_publikasi" style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: var(--text-main);">Tanggal Publikasi <span style="color: var(--danger);">*</span></label>
                    <input type="date" id="tanggal_publikasi" name="tanggal_publikasi" value="{{ \Carbon\Carbon::parse($berita->tanggal_publikasi)->format('Y-m-d') }}" required class="form-control">
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label for="gambar" style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: var(--text-main);">Upload Gambar Baru (Opsional)</label>
                    <input type="file" id="gambar" name="gambar" accept="image/*" class="form-control">
                    <small style="color: var(--text-muted); display: block; margin-top: 0.25rem;">Kosongkan jika tidak ingin mengubah gambar.</small>
                </div>

                <div style="margin-bottom: 2rem;">
                    <label for="isi" style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: var(--text-main);">Isi Berita <span style="color: var(--danger);">*</span></label>
                    <textarea id="isi" name="isi" required rows="10" class="form-control" style="resize: vertical;">{{ $berita->isi }}</textarea>
                </div>

                <div class="action-group">
                    <button type="submit" class="btn btn-primary">
                        <i data-feather="save"></i> Update Berita
                    </button>
                    <a href="{{ route('admin.berita.index') }}" class="btn btn-secondary">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="dashboard-card" style="display: block;">
            <h3 style="font-size: 1.1rem; font-weight: 600; margin-bottom: 1rem; color: var(--text-main);">Gambar Saat Ini</h3>
            @if($berita->gambar)
                <img src="{{ asset('storage/' . $berita->gambar) }}" alt="Gambar Berita" style="width: 100%; height: auto; border-radius: 8px; border: 1px solid var(--border-color);">
            @else
                <div style="width: 100%; height: 200px; background: var(--bg-main); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: var(--text-muted); border: 1px dashed var(--border-color);">
                    <div style="text-align: center;">
                        <i data-feather="image" style="width: 32px; height: 32px; margin-bottom: 8px;"></i>
                        <p style="margin: 0; font-size: 0.9rem;">Tidak ada gambar</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection