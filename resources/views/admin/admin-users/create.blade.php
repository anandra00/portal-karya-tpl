@extends('admin.layouts.app')

@section('title', 'Tambah Admin')

@section('content')
<div class="page-header" style="display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h1 class="page-title">Tambah Admin Baru</h1>
        <p class="page-subtitle">Berikan akses administrator ke sistem</p>
    </div>
    <a href="{{ route('admin.list') }}" class="btn btn-secondary">
        <i data-feather="arrow-left"></i> Kembali
    </a>
</div>

<div class="form-card" style="max-width: 600px;">
    @if ($errors->any())
        <div style="background-color: #FEE2E2; color: #991B1B; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; border: 1px solid #F87171;">
            <ul style="margin: 0; padding-left: 1.5rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.store') }}" method="POST">
        @csrf

        <div style="margin-bottom: 1.5rem;">
            <label for="name" style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: var(--text-main);">Nama Lengkap <span style="color: var(--danger);">*</span></label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required class="form-control" placeholder="Masukkan nama admin">
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label for="email" style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: var(--text-main);">Alamat Email <span style="color: var(--danger);">*</span></label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required class="form-control" placeholder="admin@apps.ipb.ac.id">
        </div>

        <div style="margin-bottom: 2rem;">
            <label for="password" style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: var(--text-main);">Password <span style="color: var(--danger);">*</span></label>
            <input type="password" id="password" name="password" required class="form-control" placeholder="Minimal 8 karakter">
        </div>

        <div class="action-group">
            <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">
                <i data-feather="save"></i> Simpan Admin
            </button>
        </div>
    </form>
</div>
@endsection
