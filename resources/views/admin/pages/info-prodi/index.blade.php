@extends('admin.layouts.app')

@section('title', 'Info Prodi')

@section('content')
<div class="page-header" style="display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h1 class="page-title">Info Program Studi</h1>
        <p class="page-subtitle">Kelola informasi profil, visi misi, dan capaian program studi</p>
    </div>
</div>

<div class="card-grid" style="grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));">
    
    {{-- Video Profil --}}
    <div class="dashboard-card" style="display: flex; flex-direction: column; justify-content: space-between; gap: 1rem;">
        <div style="display: flex; align-items: center; gap: 1rem;">
            <div style="width: 50px; height: 50px; border-radius: 12px; background: rgba(37, 99, 235, 0.1); color: var(--primary); display: flex; align-items: center; justify-content: center;">
                <i data-feather="video" style="width: 24px; height: 24px;"></i>
            </div>
            <div>
                <h3 style="font-size: 1.1rem; font-weight: 600; margin: 0; color: var(--text-main);">Video Profil</h3>
                <p style="font-size: 0.85rem; color: var(--text-muted); margin: 0;">Kelola video pengenalan</p>
            </div>
        </div>
        <a href="{{ route('info-prodi.editType', ['kodeProdi' => $profil->kode_prodi, 'type' => 'video']) }}" class="btn btn-secondary" style="width: 100%; justify-content: center;">
            <i data-feather="edit-2"></i> Edit Video
        </a>
    </div>

    {{-- Visi Misi --}}
    <div class="dashboard-card" style="display: flex; flex-direction: column; justify-content: space-between; gap: 1rem;">
        <div style="display: flex; align-items: center; gap: 1rem;">
            <div style="width: 50px; height: 50px; border-radius: 12px; background: rgba(16, 185, 129, 0.1); color: var(--success); display: flex; align-items: center; justify-content: center;">
                <i data-feather="target" style="width: 24px; height: 24px;"></i>
            </div>
            <div>
                <h3 style="font-size: 1.1rem; font-weight: 600; margin: 0; color: var(--text-main);">Visi & Misi</h3>
                <p style="font-size: 0.85rem; color: var(--text-muted); margin: 0;">Kelola tujuan program studi</p>
            </div>
        </div>
        <a href="{{ route('info-prodi.editType', ['kodeProdi' => $profil->kode_prodi, 'type' => 'visi-misi']) }}" class="btn btn-secondary" style="width: 100%; justify-content: center;">
            <i data-feather="edit-2"></i> Edit Visi Misi
        </a>
    </div>

    {{-- Capaian --}}
    <div class="dashboard-card" style="display: flex; flex-direction: column; justify-content: space-between; gap: 1rem;">
        <div style="display: flex; align-items: center; gap: 1rem;">
            <div style="width: 50px; height: 50px; border-radius: 12px; background: rgba(245, 158, 11, 0.1); color: var(--warning); display: flex; align-items: center; justify-content: center;">
                <i data-feather="award" style="width: 24px; height: 24px;"></i>
            </div>
            <div>
                <h3 style="font-size: 1.1rem; font-weight: 600; margin: 0; color: var(--text-main);">Capaian</h3>
                <p style="font-size: 0.85rem; color: var(--text-muted); margin: 0;">Kelola prestasi & capaian</p>
            </div>
        </div>
        <a href="{{ route('info-prodi.editType', ['kodeProdi' => $profil->kode_prodi, 'type' => 'capaian']) }}" class="btn btn-secondary" style="width: 100%; justify-content: center;">
            <i data-feather="edit-2"></i> Edit Capaian
        </a>
    </div>

</div>
@endsection