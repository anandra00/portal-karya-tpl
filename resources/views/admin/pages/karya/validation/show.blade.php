@extends('admin.layouts.app')

@section('title', 'Validasi Karya')

@section('content')
<div class="page-header" style="display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h1 class="page-title">Validasi Karya</h1>
        <p class="page-subtitle">Periksa dan berikan keputusan untuk karya mahasiswa</p>
    </div>
    <a href="{{ route('karya.validasi') }}" class="btn btn-secondary">
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
                    <input type="text" name="judul" value="{{ $karya->judul }}" class="form-control" readonly>
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: var(--text-main);">Deskripsi</label>
                    <textarea name="deskripsi" rows="5" class="form-control" readonly>{{ $karya->deskripsi }}</textarea>
                </div>

                <div class="row g-3" style="margin-bottom: 1.5rem;">
                    <div class="col-md-6">
                        <label style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: var(--text-main);">Tim Pembuat</label>
                        <input type="text" name="tim_pembuat" value="{{ $karya->tim_pembuat }}" class="form-control" readonly>
                    </div>
                    <div class="col-md-6">
                        <label style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: var(--text-main);">Tahun</label>
                        <input type="number" name="tahun" value="{{ $karya->tahun }}" class="form-control" readonly>
                    </div>
                </div>

                <div style="margin-bottom: 2rem;">
                    <label style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: var(--text-main);">Pengumpulan (Link/PDF)</label>
                    @if($karya->link_pengumpulan)
                        <div style="display: flex; gap: 10px;">
                            <input type="text" name="link_pengumpulan" value="{{ $karya->link_pengumpulan }}" class="form-control" readonly>
                            <a href="{{ $karya->link_pengumpulan }}" target="_blank" class="btn btn-secondary" style="white-space: nowrap;">
                                Buka Link
                            </a>
                        </div>
                    @else
                        <input type="text" value="Tidak ada link disertakan" class="form-control" readonly>
                    @endif
                </div>

                <hr style="border-color: var(--border-color); margin: 2rem 0;">

                <h3 style="font-size: 1.1rem; font-weight: 600; margin-bottom: 1.5rem; color: var(--text-main);">Keputusan Validasi</h3>
                
                <div style="margin-bottom: 1.5rem;">
                    <label for="status" style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: var(--text-main);">Pilih Status</label>
                    <select id="status" name="status_validasi" class="form-control" required style="border-color: var(--primary); border-width: 2px;">
                        <option value="" disabled selected>-- Pilih Keputusan --</option>
                        <option value="accepted">Terima (Accepted)</option>
                        <option value="rejected">Tolak (Rejected)</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; font-size: 1.05rem; padding: 0.75rem;">
                    <i data-feather="check-circle"></i> Konfirmasi Validasi
                </button>
            </form>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="dashboard-card" style="display: block;">
            <h3 style="font-size: 1.1rem; font-weight: 600; margin-bottom: 1rem; color: var(--text-main);">Preview Gambar</h3>
            @if($karya->preview_karya)
                <img src="{{ asset('storage/' . $karya->preview_karya) }}" alt="Preview" style="width: 100%; height: auto; border-radius: 8px; border: 1px solid var(--border-color);">
                <a href="{{ asset('storage/' . $karya->preview_karya) }}" target="_blank" class="btn btn-secondary mt-3" style="width: 100%; justify-content: center;">
                    <i data-feather="external-link"></i> Buka Gambar Penuh
                </a>
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
