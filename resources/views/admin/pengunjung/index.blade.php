@extends('admin.layouts.app')

@section('title', 'Daftar Pengunjung')

@section('content')
<div class="page-header">
    <h1 class="page-title">Daftar Pengunjung</h1>
    <p class="page-subtitle">Semua pengguna yang terdaftar pada sistem Portal Prodi TPL</p>
</div>

<div class="table-container">
    <div class="table-header">
        <h3>Data Pengunjung</h3>
        <span class="badge badge-primary" style="background-color: rgba(79, 70, 229, 0.1); color: var(--primary);">Total: {{ count($users) }}</span>
    </div>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Profil</th>
                    <th>Nama Pengguna</th>
                    <th>Email</th>
                    <th>Waktu Bergabung</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random" 
                                 alt="Avatar" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                        </td>
                        <td>
                            <strong style="color: var(--text-main);">{{ $user->name }}</strong>
                        </td>
                        <td>
                            {{ $user->email }}
                        </td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 6px; color: var(--text-muted); font-size: 0.9rem;">
                                <i data-feather="clock" style="width: 14px; height: 14px;"></i>
                                {{ $user->created_at->format('d M Y, H:i') }}
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 2rem; color: var(--text-muted);">
                            Tidak ada data pengunjung ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection