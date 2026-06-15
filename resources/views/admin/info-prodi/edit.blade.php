@extends('admin.layouts.app')

@section('title', 'Edit Info Prodi')

@section('content')
<div class="page-header" style="display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h1 class="page-title">Edit Info Prodi</h1>
        <p class="page-subtitle">Perbarui informasi {{ str_replace('-', ' ', $type) }} program studi</p>
    </div>
    <a href="{{ route('info-prodi.index') }}" class="btn btn-secondary">
        <i data-feather="arrow-left"></i> Kembali
    </a>
</div>

<div class="form-card" style="max-width: 800px;">
    <form action="{{ route('info-prodi.update', $profil->kode_prodi) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        @switch($type)
            @case('video')
                <div style="margin-bottom: 2rem;">
                    <label style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: var(--text-main);">Upload Video Baru</label>
                    <input type="file" name="video" accept="video/*" class="form-control">
                    <small style="color: var(--text-muted); display: block; margin-top: 0.5rem;">Format disarankan: MP4. Maksimal ukuran sesuai konfigurasi server.</small>
                </div>
            @break

            @case('visi-misi')
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: var(--text-main);">Visi</label>
                    <textarea name="visi" class="form-control" style="height: 150px; resize: vertical;" placeholder="Masukkan visi program studi...">{{ $profil->visi }}</textarea>
                </div>

                <div style="margin-bottom: 2rem;">
                    <label style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: var(--text-main);">Misi</label>
                    <textarea name="misi" class="form-control" style="height: 250px; resize: vertical;" placeholder="Masukkan misi program studi...">{{ $profil->misi }}</textarea>
                </div>
            @break

            @case('capaian')
                <div style="margin-bottom: 2rem;">
                    <label style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: var(--text-main);">Capaian</label>
                    <textarea name="capaian" class="form-control" style="height: 250px; resize: vertical;" placeholder="Masukkan capaian program studi...">{{ $profil->capaian }}</textarea>
                </div>
            @break
        @endswitch

        <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">
            <i data-feather="save"></i> Simpan Perubahan
        </button>
    </form>
</div>
@endsection