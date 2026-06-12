@extends('admin.layouts.app')

@section('title', 'Tambah Karya')

@section('content')
<div class="page-header" style="display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h1 class="page-title">Tambah Karya</h1>
        <p class="page-subtitle">Formulir penambahan karya mahasiswa baru</p>
    </div>
    <a href="{{ route('karya.index') }}" class="btn btn-secondary">
        <i data-feather="arrow-left"></i> Kembali
    </a>
</div>

<div class="dashboard-card" style="display: block;">
    @if ($errors->any())
        <div style="background-color: #FEE2E2; color: #991B1B; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; border: 1px solid #F87171;">
            <div style="display: flex; align-items: center; gap: 8px; font-weight: 600; margin-bottom: 0.5rem;">
                <i data-feather="alert-circle" style="width: 18px; height: 18px;"></i> Oops! Ada kesalahan:
            </div>
            <ul style="margin: 0; padding-left: 1.5rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('karya.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div style="margin-bottom: 1.5rem;">
            <label for="judul" style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: var(--text-main);">Judul Karya <span style="color: var(--danger);">*</span></label>
            <input type="text" id="judul" name="judul" value="{{ old('judul') }}" required 
                   placeholder="Contoh: Sistem Informasi Pengelolaan Data Mahasiswa"
                   class="form-control">
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label for="kategori" style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: var(--text-main);">Kategori <span style="color: var(--danger);">*</span></label>
            <select id="kategori" name="kategori" required class="form-control">
                <option value="">Pilih Kategori</option>
                <option value="Web Development" {{ old('kategori') == 'Web Development' ? 'selected' : '' }}>Web Development</option>
                <option value="Mobile Apps" {{ old('kategori') == 'Mobile Apps' ? 'selected' : '' }}>Mobile Apps</option>
                <option value="Data Science" {{ old('kategori') == 'Data Science' ? 'selected' : '' }}>Data Science</option>
                <option value="IoT" {{ old('kategori') == 'IoT' ? 'selected' : '' }}>Internet of Things</option>
                <option value="Game Development" {{ old('kategori') == 'Game Development' ? 'selected' : '' }}>Game Development</option>
                <option value="Lainnya" {{ old('kategori') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
            </select>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label for="deskripsi" style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: var(--text-main);">Deskripsi <span style="color: var(--danger);">*</span></label>
            <textarea id="deskripsi" name="deskripsi" required rows="5"
                      placeholder="Jelaskan detail tentang karya ini..."
                      class="form-control">{{ old('deskripsi') }}</textarea>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label for="tim_pembuat" style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: var(--text-main);">Tim Pembuat <span style="color: var(--danger);">*</span></label>
            <input type="text" id="tim_pembuat" name="tim_pembuat" value="{{ old('tim_pembuat') }}" required 
                   placeholder="Contoh: Salsabila dan Tim Syntax Error"
                   class="form-control">
        </div>

        <div class="row g-3" style="margin-bottom: 1.5rem;">
            <div class="col-md-6">
                <label for="tahun" style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: var(--text-main);">Tahun <span style="color: var(--danger);">*</span></label>
                <select id="tahun" name="tahun" required class="form-control">
                    <option value="">Pilih Tahun</option>
                    @for ($year = date('Y'); $year >= 2020; $year--)
                        <option value="{{ $year }}" {{ old('tahun', date('Y')) == $year ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                    @endfor
                </select>
            </div>
            
            <div class="col-md-6">
                <label for="link" style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: var(--text-main);">Pengumpulan (Link/PDF)</label>
                <input type="url" id="link" name="link" value="{{ old('link') }}" 
                       placeholder="https://drive.google.com/karya123"
                       class="form-control">
                <small style="color: var(--text-muted); display: block; margin-top: 0.25rem;">Link Google Drive, GitHub, atau URL lainnya</small>
            </div>
        </div>

        <div style="margin-bottom: 2rem;">
            <label for="preview_karya" style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: var(--text-main);">Screenshot/Gambar Karya</label>
            <input type="file" id="preview_karya" name="preview_karya" accept="image/*" class="form-control">
            <small style="color: var(--text-muted); display: block; margin-top: 0.25rem;">Format: JPG, PNG, max 2MB</small>
        </div>

        <div class="action-group">
            <button type="submit" class="btn btn-primary">
                <i data-feather="save"></i> Simpan ke Validasi
            </button>
            <a href="{{ route('karya.index') }}" class="btn btn-secondary">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection