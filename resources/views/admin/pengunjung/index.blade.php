@extends('admin.layouts.app')

@section('title', 'Daftar Pengunjung')

@push('styles')
<style>
    .tabs-container {
        display: flex;
        border-bottom: 2px solid var(--border-color);
        margin-bottom: 1.5rem;
        gap: 1.5rem;
    }
    .tab-button {
        background: none;
        border: none;
        padding: 0.75rem 0.5rem;
        font-size: 1rem;
        font-weight: 600;
        color: var(--text-muted);
        cursor: pointer;
        position: relative;
        transition: var(--transition-fast);
        outline: none;
    }
    .tab-button:hover {
        color: var(--primary);
    }
    .tab-button.active {
        color: var(--primary);
    }
    .tab-button.active::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 100%;
        height: 2px;
        background-color: var(--primary);
    }
    .tab-content {
        display: none;
    }
    .tab-content.active {
        display: block;
    }
</style>
@endpush

@section('content')
<!-- Page Header -->
<div class="page-header" style="margin-bottom: 1.5rem;">
    <div>
        <h1 class="page-title">Statistik & Pengunjung</h1>
        <p class="page-subtitle">Kelola data pengguna terdaftar dan pantau lalu lintas kunjungan situs secara real-time</p>
    </div>
</div>

<!-- Tabs Navigation -->
<div class="tabs-container">
    <button class="tab-button active" data-target="tab-users">
        <i data-feather="users" style="width: 16px; height: 16px; margin-right: 4px; vertical-align: middle;"></i>
        Pengguna Terdaftar
    </button>
    <button class="tab-button" data-target="tab-visitors">
        <i data-feather="activity" style="width: 16px; height: 16px; margin-right: 4px; vertical-align: middle;"></i>
        Log Kunjungan Website
    </button>
</div>

<!-- Tab 1: Pengguna Terdaftar -->
<div id="tab-users" class="tab-content active">
    <div class="page-header d-flex justify-content-between align-items-center" style="margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h2 style="font-size: 1.25rem; font-weight: 600; color: var(--text-main);">Daftar Pengguna</h2>
            <p style="font-size: 0.9rem; color: var(--text-muted);">Semua pengguna yang terdaftar pada sistem Portal Prodi TPL</p>
        </div>
        <a href="{{ route('pengunjung.export') }}" class="btn btn-success" style="padding: 0.5rem 1rem; border-radius: 8px; display: inline-flex; align-items: center; gap: 6px;">
            <i data-feather="download" style="width: 18px; height: 18px;"></i> Export Excel
        </a>
    </div>

    <div class="table-container">
        <div class="table-header">
            <h3>Data Pengguna</h3>
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
                                Tidak ada data pengguna ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Tab 2: Log Kunjungan Website -->
<div id="tab-visitors" class="tab-content">
    <div class="page-header d-flex justify-content-between align-items-center" style="margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h2 style="font-size: 1.25rem; font-weight: 600; color: var(--text-main);">Log Kunjungan Website</h2>
            <p style="font-size: 0.9rem; color: var(--text-muted);">Riwayat akses halaman publik Portal Prodi TPL secara real-time</p>
        </div>
        
        <form action="{{ route('pengunjung.clear') }}" method="POST" class="delete-form" data-name="Seluruh Log Kunjungan Website">
            @csrf
            <button type="submit" class="btn btn-danger" style="padding: 0.5rem 1rem; border-radius: 8px; display: inline-flex; align-items: center; gap: 6px;">
                <i data-feather="trash-2" style="width: 18px; height: 18px;"></i> Hapus Semua Log
            </button>
        </form>
    </div>

    <div class="table-container">
        <div class="table-header">
            <h3>Log Lalu Lintas Pengunjung</h3>
            <span class="badge badge-primary" style="background-color: rgba(79, 70, 229, 0.1); color: var(--primary);">Total: {{ $visitors->total() }} Kunjungan</span>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>IP Address</th>
                        <th>Nama / Identitas</th>
                        <th>Browser & Perangkat</th>
                        <th>Halaman yang Dikunjungi</th>
                        <th style="text-align: right;">Waktu Kunjungan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($visitors as $v)
                        <tr>
                            <td>
                                <span style="font-family: monospace; font-weight: 600; color: var(--text-main); background: var(--bg-main); padding: 0.25rem 0.5rem; border-radius: 4px; border: 1px solid var(--border-color);">
                                    {{ $v->ip_address }}
                                </span>
                            </td>
                            <td>
                                <strong style="color: var(--text-main);">{{ $v->nama }}</strong>
                                <div style="font-size: 0.8rem; color: var(--text-muted);">{{ $v->email }}</div>
                            </td>
                            <td>
                                <div style="display: flex; flex-direction: column; gap: 4px;">
                                    <span style="display: inline-flex; align-items: center; gap: 4px; font-size: 0.85rem;">
                                        @if($v->browser === 'Chrome')
                                            <i data-feather="chrome" style="width: 14px; height: 14px; color: var(--primary);"></i>
                                        @elseif($v->browser === 'Firefox')
                                            <i data-feather="firefox" style="width: 14px; height: 14px; color: var(--warning);"></i>
                                        @elseif($v->browser === 'Safari')
                                            <i data-feather="compass" style="width: 14px; height: 14px; color: var(--success);"></i>
                                        @elseif($v->browser === 'Edge')
                                            <i data-feather="activity" style="width: 14px; height: 14px; color: var(--info);"></i>
                                        @else
                                            <i data-feather="globe" style="width: 14px; height: 14px; color: var(--text-muted);"></i>
                                        @endif
                                        <strong>{{ $v->browser }}</strong>
                                    </span>
                                    <span style="font-size: 0.75rem; color: var(--text-muted); display: inline-flex; align-items: center; gap: 4px;">
                                        @if($v->device === 'Mobile')
                                            <i data-feather="smartphone" style="width: 12px; height: 12px;"></i>
                                        @elseif($v->device === 'Tablet')
                                            <i data-feather="tablet" style="width: 12px; height: 12px;"></i>
                                        @else
                                            <i data-feather="monitor" style="width: 12px; height: 12px;"></i>
                                        @endif
                                        {{ $v->device }}
                                    </span>
                                </div>
                            </td>
                            <td>
                                <span style="font-size: 0.85rem; color: var(--primary); font-weight: 500; word-break: break-all;">
                                    {{ Str::after($v->page_visited, request()->getSchemeAndHttpHost()) ?: '/' }}
                                </span>
                            </td>
                            <td style="text-align: right;">
                                <div style="color: var(--text-main); font-weight: 500; font-size: 0.85rem;">
                                    {{ $v->visited_at->format('d M Y, H:i') }}
                                </div>
                                <small style="color: var(--text-muted); font-size: 0.75rem;">
                                    {{ $v->time_ago }}
                                </small>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 3rem 1rem; color: var(--text-muted);">
                                <i data-feather="activity" style="width: 48px; height: 48px; margin-bottom: 1rem; opacity: 0.5;"></i>
                                <p style="margin: 0; font-size: 1.1rem;">Belum ada riwayat kunjungan.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($visitors->hasPages())
        <div style="padding: 1.5rem; border-top: 1px solid var(--border-color); display: flex; justify-content: center;">
            {{ $visitors->appends(request()->except('page_visitors'))->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabButtons = document.querySelectorAll('.tab-button');
        const tabContents = document.querySelectorAll('.tab-content');

        // Check if there is page_visitors in URL query params
        const urlParams = new URLSearchParams(window.location.search);
        const hasVisitorPage = urlParams.has('page_visitors');

        function switchTab(tabId) {
            tabButtons.forEach(btn => {
                if (btn.getAttribute('data-target') === tabId) {
                    btn.classList.add('active');
                } else {
                    btn.classList.remove('active');
                }
            });

            tabContents.forEach(content => {
                if (content.id === tabId) {
                    content.classList.add('active');
                } else {
                    content.classList.remove('active');
                }
            });
            
            // Re-render Feather icons in the active tab to be safe
            feather.replace();
        }

        tabButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const target = this.getAttribute('data-target');
                switchTab(target);
                
                // Update URL query param to remember the tab state without reloading
                const newUrl = new URL(window.location.href);
                if (target === 'tab-visitors') {
                    newUrl.searchParams.set('tab', 'visitors');
                } else {
                    newUrl.searchParams.delete('tab');
                }
                window.history.replaceState({}, '', newUrl);
            });
        });

        // Handle initial load tab state
        const urlTab = urlParams.get('tab');
        if (urlTab === 'visitors' || hasVisitorPage) {
            switchTab('tab-visitors');
        } else {
            switchTab('tab-users');
        }
    });
</script>
@endpush