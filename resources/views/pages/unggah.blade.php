@extends('layouts.app')

@section('title', 'Unggah Karya')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/detailkarya.css') }}">
@endpush

@section('hero')
@include('partials.hero', ['title' => 'Unggah Karya Mahasiswa', 'subtitle' => 'Bagikan Karya Terbaikmu'])
@endsection

@section('content')
<main class="detail-section py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 fade-in-up">
                <div class="card p-4">
                    <h3 class="mb-4 fw-bold">Form Unggah Karya</h3>
                    
                    {{-- Pesan Error --}}
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Oops!</strong> Ada beberapa masalah:
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    {{-- Pesan Sukses --}}
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Berhasil!</strong> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    <form action="{{ route('karya.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        {{-- 1. Judul Karya --}}
                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul Karya <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('judul') is-invalid @enderror" 
                                   id="judul" 
                                   name="judul" 
                                   value="{{ old('judul') }}" 
                                   required 
                                   placeholder="Masukkan judul karya">
                            @error('judul')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- 2. Kategori --}}
                        <div class="mb-3">
                            <label for="kategori" class="form-label">Kategori <span class="text-danger">*</span></label>
                            <select class="form-select @error('kategori') is-invalid @enderror" 
                                    id="kategori" 
                                    name="kategori" 
                                    required>
                                <option value="">Pilih Kategori</option>
                                @foreach(['Web Development', 'Mobile Apps', 'Data Science', 'IoT', 'Game Development', 'Lainnya'] as $kat)
                                    <option value="{{ $kat }}" {{ old('kategori') == $kat ? 'selected' : '' }}>{{ $kat == 'IoT' ? 'Internet of Things' : $kat }}</option>
                                @endforeach
                            </select>
                            @error('kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- 3. Nama Tim/Pembuat --}}
                        <div class="mb-3">
                            <label for="tim_pembuat" class="form-label">Nama Tim/Pembuat <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('tim_pembuat') is-invalid @enderror" 
                                   id="tim_pembuat" 
                                   name="tim_pembuat" 
                                   value="{{ old('tim_pembuat') }}" 
                                   required 
                                   placeholder="Contoh: Tim StockNest">
                            @error('tim_pembuat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- 4. Tahun --}}
                        <div class="mb-3">
                            <label for="tahun" class="form-label">Tahun <span class="text-danger">*</span></label>
                            <select class="form-select @error('tahun') is-invalid @enderror" 
                                    id="tahun" 
                                    name="tahun" 
                                    required>
                                <option value="">Pilih Tahun</option>
                                @for ($year = date('Y'); $year >= 2020; $year--)
                                    <option value="{{ $year }}" {{ old('tahun', date('Y')) == $year ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endfor
                            </select>
                            @error('tahun')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- 5. Email --}}
                        <div class="mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email', Auth::user()->email ?? '') }}" 
                                   required 
                                   readonly
                                   placeholder="pembuat@gmail.com">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- 6. Deskripsi --}}
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi Karya <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                      id="deskripsi" 
                                      name="deskripsi" 
                                      rows="5" 
                                      required 
                                      placeholder="Jelaskan detail tentang karyamu...">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- 7. Link Pengumpulan --}}
                        <div class="mb-3">
                            <label for="link" class="form-label">Pengumpulan (Link)</label>
                            <input type="url" 
                                   class="form-control @error('link') is-invalid @enderror" 
                                   id="link" 
                                   name="link" 
                                   value="{{ old('link') }}" 
                                   placeholder="https://drive.google.com/karya123">
                            <small class="text-muted">Link Google Drive, GitHub, atau URL lainnya</small>
                            @error('link')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- 8. Upload Gambar --}}
                        <div class="mb-4">
                            <label for="gambar" class="form-label">Screenshot/Gambar Karya <span class="text-danger">*</span></label>
                            <input type="file" 
                                   class="form-control @error('gambar') is-invalid @enderror" 
                                   id="gambar" 
                                   name="preview_karya" 
                                   accept="image/*" 
                                   required>
                            <small class="text-muted">Format: JPG, PNG, max 2MB</small>
                            @error('gambar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Buttons --}}
                        <div class="d-flex flex-wrap gap-2">
                            <button type="submit" class="btn btn-tpl">
                                <i class="bi bi-upload me-2"></i>Unggah Karya
                            </button>
                            <a href="{{ route('home') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-2"></i>Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection