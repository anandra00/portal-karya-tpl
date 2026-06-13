@extends('admin.layouts.app')

@section('title', 'Activity Log')

@section('content')
<div class="page-header" style="display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h1 class="page-title">Activity Log (Jejak Audit)</h1>
        <p class="page-subtitle">Daftar semua aktivitas yang tercatat dalam sistem</p>
    </div>
</div>

<div class="dashboard-card" style="display: block; overflow-x: auto;">
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="border-bottom: 2px solid var(--border-color); color: var(--text-muted); text-align: left;">
                <th style="padding: 1rem;">Tipe</th>
                <th style="padding: 1rem;">Aksi</th>
                <th style="padding: 1rem;">Deskripsi</th>
                <th style="padding: 1rem;">Aktor</th>
                <th style="padding: 1rem; text-align: right;">Waktu</th>
            </tr>
        </thead>
        <tbody>
            @forelse($logs as $log)
                <tr style="border-bottom: 1px solid var(--border-color);">
                    <td style="padding: 1rem;">
                        <span style="display: inline-flex; align-items: center; background: rgba(107, 114, 128, 0.1); color: var(--text-muted); padding: 0.25rem 0.75rem; border-radius: 999px; font-weight: 600; font-size: 0.85rem;">
                            {{ $log->type }}
                        </span>
                    </td>
                    <td style="padding: 1rem; color: var(--text-main); font-weight: 600;">
                        {{ $log->action }}
                    </td>
                    <td style="padding: 1rem; color: var(--text-muted); max-width: 300px; white-space: normal;">
                        {{ $log->deskripsi }}
                    </td>
                    <td style="padding: 1rem; color: var(--text-main);">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <i data-feather="user" style="width: 16px; height: 16px; color: var(--primary);"></i>
                            <span>{{ $log->validasi ?? 'Sistem' }}</span>
                        </div>
                    </td>
                    <td style="padding: 1rem; text-align: right; color: var(--text-muted); font-size: 0.9rem;">
                        {{ $log->created_at->diffForHumans() }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 3rem 1rem; color: var(--text-muted);">
                        <i data-feather="clock" style="width: 48px; height: 48px; margin-bottom: 1rem; opacity: 0.5;"></i>
                        <p style="margin: 0; font-size: 1.1rem;">Belum ada aktivitas tercatat.</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    @if($logs->hasPages())
    <div style="padding: 1.5rem; border-top: 1px solid var(--border-color); display: flex; justify-content: center;">
        {{ $logs->links() }}
    </div>
    @endif
</div>
@endsection
