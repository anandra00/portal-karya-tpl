@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1 class="page-title">Dashboard</h1>
        <p class="page-subtitle">Selamat datang di Portal Karya Teknologi Rekayasa Perangkat Lunak SV IPB</p>
    </div>
    @if (Auth::check() && Auth::user()->role == 'superadmin')
    <a href="{{ route('admin.backup') }}" class="btn btn-danger" style="padding: 0.5rem 1rem; border-radius: 8px;">
        <i data-feather="database" style="width: 18px; height: 18px; margin-right: 4px;"></i> Backup Database
    </a>
    @endif
</div>

<div class="card-grid">
    <div class="dashboard-card" style="position: relative;">
        <div class="card-info">
            <h3>Ajuan Karya</h3>
            <p>{{ $ajuan_karya }}</p>
        </div>
        <div class="card-icon">
            <i data-feather="file-text"></i>
        </div>
        <a href="{{ route('ajuankarya') }}" class="btn btn-secondary dashboard-card-link">Lihat</a>
    </div>

    <div class="dashboard-card" style="position: relative;">
        <div class="card-info">
            <h3>Karya Terunggah</h3>
            <p>{{ $karya_terunggah }}</p>
        </div>
        <div class="card-icon">
            <i data-feather="upload-cloud"></i>
        </div>
        <a href="{{ route('lihatkarya') }}" class="btn btn-secondary dashboard-card-link">Lihat</a>
    </div>

    <div class="dashboard-card" style="position: relative;">
        <div class="card-info">
            <h3>Pengunjung</h3>
            <p>{{ $pengunjung }}</p>
        </div>
        <div class="card-icon">
            <i data-feather="users"></i>
        </div>
        <a href="{{ route('lihatpengunjung') }}" class="btn btn-secondary dashboard-card-link">Lihat</a>
    </div>
</div>
@endsection