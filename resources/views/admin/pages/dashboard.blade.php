@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="page-header">
    <h1 class="page-title">Dashboard</h1>
    <p class="page-subtitle">Selamat datang di Portal Karya Teknologi Rekayasa Perangkat Lunak SV IPB</p>
</div>

<div class="card-grid">
    <div class="dashboard-card" style="position: relative;">
        <div class="card-info">
            <h3>Ajuan Karya</h3>
            <p>0</p>
        </div>
        <div class="card-icon">
            <i data-feather="file-text"></i>
        </div>
        <a href="{{ route('ajuankarya') }}" class="btn btn-secondary dashboard-card-link">Lihat</a>
    </div>

    <div class="dashboard-card" style="position: relative;">
        <div class="card-info">
            <h3>Karya Terunggah</h3>
            <p>0</p>
        </div>
        <div class="card-icon">
            <i data-feather="upload-cloud"></i>
        </div>
        <a href="{{ route('lihatkarya') }}" class="btn btn-secondary dashboard-card-link">Lihat</a>
    </div>

    <div class="dashboard-card" style="position: relative;">
        <div class="card-info">
            <h3>Pengunjung</h3>
            <p>0</p>
        </div>
        <div class="card-icon">
            <i data-feather="users"></i>
        </div>
        <a href="{{ route('lihatpengunjung') }}" class="btn btn-secondary dashboard-card-link">Lihat</a>
    </div>
</div>
@endsection