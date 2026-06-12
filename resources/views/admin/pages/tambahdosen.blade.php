@extends('admin.layouts.app')

@section('title', 'Tambah Dosen')

@section('content')
<div class="page-header">
    <h1 class="page-title">Tambah Dosen</h1>
    <p class="page-subtitle">Masukkan data dosen baru untuk program studi</p>
</div>

<div class="form-card">
    <form action="{{ route('dosen.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="form-group">
            <label class="form-label" for="foto">Unggah Foto</label>
            <input type="file" id="foto" name="foto" class="form-control" accept="image/*">
            <small style="color: var(--text-muted); display: block; margin-top: 0.25rem;">Format gambar (.jpg, .jpeg, .png). Maksimal 2MB.</small>
        </div>

        <div class="form-group">
            <label class="form-label" for="nama">Nama Dosen</label>
            <input type="text" id="nama" name="nama" class="form-control" placeholder="Masukkan Nama Lengkap" required>
        </div>

        <div class="form-group">
            <label class="form-label" for="research_interest">Bidang Keahlian</label>
            <input type="text" id="research_interest" name="research_interest" class="form-control" placeholder="Contoh: Pemrograman, AI, Jaringan">
        </div>
        
        <div class="form-group">
            <label class="form-label" for="prodi">Program Studi</label>
            <input type="text" id="prodi" name="prodi" class="form-control" placeholder="Contoh: Teknologi Rekayasa Perangkat Lunak" value="Teknologi Rekayasa Perangkat Lunak">
        </div>

        <div class="form-group">
            <label class="form-label" for="status">Status</label>
            <select id="status" name="status" class="form-control" required>
                <option value="aktif">Aktif</option>
                <option value="non-aktif">Non-Aktif</option>
            </select>
        </div>

        <div style="margin-top: 2rem; display: flex; gap: 1rem;">
            <button type="submit" class="btn btn-primary">
                <i data-feather="save" style="width: 16px; height: 16px;"></i> Simpan Data Dosen
            </button>
            <a href="{{ route('dosen.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
