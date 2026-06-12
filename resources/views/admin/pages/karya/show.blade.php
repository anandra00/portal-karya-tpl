@extends('admin.layouts.app')

@section('title', 'Edit Karya')

@section('content')
<div class="page-header" style="display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h1 class="page-title">Edit Karya</h1>
        <p class="page-subtitle">Ubah informasi karya atau hapus karya</p>
    </div>
    <a href="{{ route('karya.index') }}" class="btn btn-secondary">
        <i data-feather="arrow-left"></i> Kembali
    </a>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="dashboard-card" style="display: block;">
            <form action="{{ route('karya.update', $karya->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: var(--text-main);">Judul Karya</label>
                    <input type="text" name="judul" value="{{ $karya->judul }}" required class="form-control">
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: var(--text-main);">Deskripsi</label>
                    <textarea name="deskripsi" required rows="5" class="form-control">{{ $karya->deskripsi }}</textarea>
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: var(--text-main);">Tim Pembuat</label>
                    <input type="text" name="tim_pembuat" value="{{ $karya->tim_pembuat }}" required class="form-control">
                </div>

                <div class="row g-3" style="margin-bottom: 1.5rem;">
                    <div class="col-md-4">
                        <label style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: var(--text-main);">Status Validasi</label>
                        <select name="status_validasi" required class="form-control">
                            <option value="submission" {{ $karya->status_validasi == 'submission' ? 'selected' : '' }}>Submission</option>
                            <option value="accepted" {{ $karya->status_validasi == 'accepted' ? 'selected' : '' }}>Accepted</option>
                            <option value="rejected" {{ $karya->status_validasi == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: var(--text-main);">Tahun</label>
                        <input type="number" name="tahun" value="{{ $karya->tahun }}" required class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: var(--text-main);">Kategori</label>
                        <input type="text" name="kategori" value="{{ $karya->kategori }}" class="form-control" readonly>
                    </div>
                </div>

                <div style="margin-bottom: 2rem;">
                    <label style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: var(--text-main);">Link/PDF</label>
                    <input type="text" name="link_pengumpulan" value="{{ $karya->link_pengumpulan }}" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">
                    <i data-feather="save"></i> Simpan Perubahan
                </button>
            </form>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="dashboard-card" style="display: block;">
            <h3 style="font-size: 1.1rem; font-weight: 600; margin-bottom: 1rem; color: var(--text-main);">Preview Gambar</h3>
            @if($karya->preview_karya)
                <img src="{{ asset('storage/' . $karya->preview_karya) }}" alt="Preview" style="width: 100%; height: auto; border-radius: 8px; margin-bottom: 1rem; border: 1px solid var(--border-color);">
            @else
                <div style="width: 100%; height: 200px; background: var(--bg-main); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: var(--text-muted); margin-bottom: 1rem; border: 1px dashed var(--border-color);">
                    <div style="text-align: center;">
                        <i data-feather="image" style="width: 32px; height: 32px; margin-bottom: 8px;"></i>
                        <p style="margin: 0; font-size: 0.9rem;">Tidak ada gambar</p>
                    </div>
                </div>
            @endif

            <hr style="border-color: var(--border-color); margin: 1.5rem 0;">

            <h3 style="font-size: 1.1rem; font-weight: 600; margin-bottom: 1rem; color: var(--danger);">Zona Bahaya</h3>
            <p style="font-size: 0.9rem; color: var(--text-muted); margin-bottom: 1rem;">Hati-hati, aksi ini tidak dapat dibatalkan. Menghapus karya ini akan menghapusnya secara permanen.</p>
            
            <form action="{{ route('karya.destroy', $karya->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus karya ini secara permanen?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" style="width: 100%; justify-content: center;">
                    <i data-feather="trash-2"></i> Hapus Karya
                </button>
            </form>
        </div>
    </div>
</div>
@endsection