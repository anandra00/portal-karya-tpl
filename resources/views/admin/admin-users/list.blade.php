@extends('admin.layouts.app')

@section('title', 'Kelola Admin')

@section('content')
<div class="page-header" style="display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h1 class="page-title">Daftar Admin</h1>
        <p class="page-subtitle">Kelola akun administrator Portal TPL</p>
    </div>
    <a href="{{ route('admin.create') }}" class="btn btn-primary">
        <i data-feather="user-plus"></i> Tambah Admin
    </a>
</div>

<div class="table-container">
    <div class="table-responsive">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="border-bottom: 2px solid var(--border-color); color: var(--text-muted); text-align: left;">
                    <th style="padding: 1rem; width: 50px;">No</th>
                    <th style="padding: 1rem;">Nama</th>
                    <th style="padding: 1rem;">Email</th>
                    <th style="padding: 1rem; text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($admins as $index => $admin)
                    <tr style="border-bottom: 1px solid var(--border-color);">
                        <td style="padding: 1rem; color: var(--text-muted);">{{ $index + 1 }}</td>
                        <td style="padding: 1rem; color: var(--text-main); font-weight: 500;">
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <div style="width: 32px; height: 32px; border-radius: 50%; background: var(--bg-main); color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 0.85rem; font-weight: 600;">
                                    {{ substr($admin->name, 0, 1) }}
                                </div>
                                {{ $admin->name }}
                            </div>
                        </td>
                        <td style="padding: 1rem; color: var(--text-muted);">{{ $admin->email }}</td>
                        <td style="padding: 1rem; text-align: right;">
                            @if($admin->id !== Auth::id())
                                <form action="{{ route('admin.delete', $admin->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus admin ini?');" style="margin: 0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" style="padding: 0.4rem 1rem; font-size: 0.85rem;">
                                        <i data-feather="trash-2"></i> Hapus
                                    </button>
                                </form>
                            @else
                                <span class="badge badge-success" style="background: rgba(16, 185, 129, 0.1); color: var(--success); padding: 0.4rem 1rem; border-radius: 8px; font-size: 0.85rem; font-weight: 600;">Anda</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 2rem; color: var(--text-muted);">
                            Belum ada data admin selain Anda.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
