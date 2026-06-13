@extends('admin.layouts.app')

@section('title', 'Info Prodi')

@section('content')
<div class="page-header" style="display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h1 class="page-title">Profil Program Studi</h1>
        <p class="page-subtitle">Kelola informasi mengenai TRPL SV IPB</p>
    </div>
</div>

<div class="card-grid" style="grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));">
    {{-- Video Profil --}}
    <div class="dashboard-card" style="flex-direction: column; align-items: flex-start;">
        <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem;">
            <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(99, 102, 241, 0.1); color: var(--primary); display: flex; align-items: center; justify-content: center;">
                <i data-feather="video" style="width: 24px; height: 24px;"></i>
            </div>
            <h3 style="font-size: 1.25rem; font-weight: 600; margin: 0; color: var(--text-main);">Video Profil</h3>
        </div>
        <p style="color: var(--text-muted); font-size: 0.95rem; margin-bottom: 2rem;">Perbarui video profil yang ditampilkan di halaman utama dan halaman tentang.</p>
        <a href="{{ route('info-prodi.editType', ['kodeProdi' => $profil->kode_prodi ?? 'TRPL', 'type' => 'video']) }}" class="btn btn-primary" style="width: 100%; justify-content: center;">
            <i data-feather="edit-2"></i> Edit Video
        </a>
    </div>

    {{-- Visi & Misi --}}
    <div class="dashboard-card" style="flex-direction: column; align-items: flex-start;">
        <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem;">
            <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(16, 185, 129, 0.1); color: var(--success); display: flex; align-items: center; justify-content: center;">
                <i data-feather="target" style="width: 24px; height: 24px;"></i>
            </div>
            <h3 style="font-size: 1.25rem; font-weight: 600; margin: 0; color: var(--text-main);">Visi & Misi</h3>
        </div>
        <p style="color: var(--text-muted); font-size: 0.95rem; margin-bottom: 2rem;">Sesuaikan teks visi dan misi dari program studi TRPL.</p>
        <a href="{{ route('info-prodi.editType', ['kodeProdi' => $profil->kode_prodi ?? 'TRPL', 'type' => 'visi-misi']) }}" class="btn btn-success" style="width: 100%; justify-content: center; background: var(--success); border-color: var(--success); color: white;">
            <i data-feather="edit-2"></i> Edit Visi Misi
        </a>
    </div>

    {{-- Capaian --}}
    <div class="dashboard-card" style="flex-direction: column; align-items: flex-start;">
        <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem;">
            <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(245, 158, 11, 0.1); color: var(--warning); display: flex; align-items: center; justify-content: center;">
                <i data-feather="award" style="width: 24px; height: 24px;"></i>
            </div>
            <h3 style="font-size: 1.25rem; font-weight: 600; margin: 0; color: var(--text-main);">Capaian</h3>
        </div>
        <p style="color: var(--text-muted); font-size: 0.95rem; margin-bottom: 2rem;">Perbarui data capaian, prestasi, dan keunggulan program studi.</p>
        <a href="{{ route('info-prodi.editType', ['kodeProdi' => $profil->kode_prodi ?? 'TRPL', 'type' => 'capaian']) }}" class="btn btn-warning" style="width: 100%; justify-content: center; background: var(--warning); border-color: var(--warning); color: white;">
            <i data-feather="edit-2"></i> Edit Capaian
        </a>
    </div>
</div>
@endsection
