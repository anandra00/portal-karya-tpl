@extends('admin.layouts.app')

@section('title', 'Kelola Review')

@section('content')
<div class="page-header" style="display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h1 class="page-title">Kelola Review dan Rating</h1>
        <p class="page-subtitle">Daftar ulasan pengguna terhadap karya mahasiswa</p>
    </div>
</div>

<div class="table-container">
    <div class="table-responsive">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="border-bottom: 2px solid var(--border-color); color: var(--text-muted); text-align: left;">
                    <th style="padding: 1rem;">User</th>
                    <th style="padding: 1rem;">Karya</th>
                    <th style="padding: 1rem;">Rating</th>
                    <th style="padding: 1rem;">Komentar</th>
                    <th style="padding: 1rem; text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($reviews as $rev)
                    <tr style="border-bottom: 1px solid var(--border-color);">
                        <td style="padding: 1rem; color: var(--text-main); font-weight: 500;">
                            {{ $rev->user->name }}
                        </td>
                        <td style="padding: 1rem; color: var(--text-main);">
                            {{ Str::limit($rev->karya->judul, 30) }}
                        </td>
                        <td style="padding: 1rem;">
                            <span style="display: inline-flex; align-items: center; gap: 4px; background: rgba(245, 158, 11, 0.1); color: var(--warning); padding: 0.25rem 0.75rem; border-radius: 999px; font-weight: 600; font-size: 0.85rem;">
                                <i data-feather="star" style="width: 14px; height: 14px; fill: currentColor;"></i> {{ $rev->rating }}
                            </span>
                        </td>
                        <td style="padding: 1rem; color: var(--text-muted); font-size: 0.95rem; max-width: 300px;">
                            {{ Str::limit($rev->comment, 50) }}
                        </td>
                        <td style="padding: 1rem; text-align: right;">
                            <form action="{{ route('admin.review.destroy', $rev->id) }}" method="POST" class="delete-form" data-name="Review oleh {{ $rev->user->name }}" style="margin: 0;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" style="padding: 0.5rem 1rem; font-size: 0.85rem;">
                                    <i data-feather="trash-2"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 3rem 1rem; color: var(--text-muted);">
                            <i data-feather="message-square" style="width: 48px; height: 48px; margin-bottom: 1rem; opacity: 0.5;"></i>
                            <p style="margin: 0; font-size: 1.1rem;">Belum ada review untuk karya manapun.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
