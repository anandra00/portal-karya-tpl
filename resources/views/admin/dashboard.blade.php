@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1 class="page-title">Dashboard</h1>
        <p class="page-subtitle">Selamat datang di Portal Karya Teknologi Rekayasa Perangkat Lunak Sekolah Vokasi IPB University</p>
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

<!-- Interactive Charts Section -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem; margin-top: 2rem;">
    <!-- Chart 1: Visitor Traffic -->
    <div class="dashboard-card" style="display: block; min-height: auto; padding-bottom: 1.5rem; background: var(--bg-card); border-radius: 16px; border: 1px solid var(--border-color); box-shadow: var(--shadow-sm);">
        <h3 style="font-size: 1.15rem; font-weight: 600; margin-bottom: 1.5rem; color: var(--text-main); display: flex; align-items: center; gap: 8px;">
            <i data-feather="trending-up" style="width: 20px; height: 20px; color: var(--primary);"></i>
            Trafik Pengunjung (7 Hari Terakhir)
        </h3>
        <div style="width: 100%; height: 280px; position: relative;">
            <canvas id="visitorChart"></canvas>
        </div>
    </div>

    <!-- Chart 2: Category Distribution -->
    <div class="dashboard-card" style="display: block; min-height: auto; padding-bottom: 1.5rem; background: var(--bg-card); border-radius: 16px; border: 1px solid var(--border-color); box-shadow: var(--shadow-sm);">
        <h3 style="font-size: 1.15rem; font-weight: 600; margin-bottom: 1.5rem; color: var(--text-main); display: flex; align-items: center; gap: 8px;">
            <i data-feather="pie-chart" style="width: 20px; height: 20px; color: var(--success);"></i>
            Distribusi Karya Per Kategori
        </h3>
        <div style="width: 100%; height: 280px; position: relative; display: flex; align-items: center; justify-content: center;">
            <canvas id="categoryChart"></canvas>
        </div>
    </div>

    <!-- Chart 3: Device / Browser Distribution -->
    <div class="dashboard-card" style="display: block; min-height: auto; padding-bottom: 1.5rem; background: var(--bg-card); border-radius: 16px; border: 1px solid var(--border-color); box-shadow: var(--shadow-sm);">
        <h3 style="font-size: 1.15rem; font-weight: 600; margin-bottom: 1.5rem; color: var(--text-main); display: flex; align-items: center; gap: 8px;">
            <i data-feather="smartphone" style="width: 20px; height: 20px; color: var(--warning);"></i>
            Browser Pengunjung
        </h3>
        <div style="width: 100%; height: 280px; position: relative; display: flex; align-items: center; justify-content: center;">
            <canvas id="deviceChart"></canvas>
        </div>
    </div>
</div>

<!-- Latest Submissions & Activity Log Grid -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 1.5rem; margin-top: 2rem;">
    <!-- Left Column: Latest Submissions -->
    <div class="dashboard-card" style="display: block; min-height: auto; padding-bottom: 1.5rem; background: var(--bg-card); border-radius: 16px; border: 1px solid var(--border-color); box-shadow: var(--shadow-sm); overflow-x: auto;">
        <h3 style="font-size: 1.15rem; font-weight: 600; margin-bottom: 1.25rem; color: var(--text-main); display: flex; align-items: center; justify-content: space-between;">
            <span style="display: flex; align-items: center; gap: 8px;">
                <i data-feather="file-text" style="width: 20px; height: 20px; color: var(--primary);"></i>
                Ajuan & Karya Terbaru
            </span>
            <a href="{{ route('lihatkarya') }}" style="font-size: 0.85rem; color: var(--primary); font-weight: 500; text-decoration: none;">Lihat Semua</a>
        </h3>
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr style="border-bottom: 2px solid var(--border-color); color: var(--text-muted); font-size: 0.85rem;">
                    <th style="padding: 0.75rem 0.5rem; font-weight: 600;">Karya</th>
                    <th style="padding: 0.75rem 0.5rem; font-weight: 600;">Kategori</th>
                    <th style="padding: 0.75rem 0.5rem; font-weight: 600; text-align: right;">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($latest_karyas as $k)
                    <tr style="border-bottom: 1px solid var(--border-color); font-size: 0.9rem;">
                        <td style="padding: 0.75rem 0.5rem; vertical-align: middle;">
                            <div style="font-weight: 600; color: var(--text-main);">{{ Str::limit($k->judul, 35) }}</div>
                            <small style="color: var(--text-muted);">Oleh: {{ $k->tim_pembuat }}</small>
                        </td>
                        <td style="padding: 0.75rem 0.5rem; color: var(--text-muted); vertical-align: middle;">
                            {{ $k->kategori }}
                        </td>
                        <td style="padding: 0.75rem 0.5rem; text-align: right; vertical-align: middle;">
                            @if($k->status_validasi === 'accepted')
                                <span style="background: rgba(16, 185, 129, 0.1); color: #10B981; padding: 0.25rem 0.5rem; border-radius: 999px; font-size: 0.75rem; font-weight: bold;">Diterima</span>
                            @elseif($k->status_validasi === 'rejected')
                                <span style="background: rgba(239, 68, 68, 0.1); color: #EF4444; padding: 0.25rem 0.5rem; border-radius: 999px; font-size: 0.75rem; font-weight: bold;">Ditolak</span>
                            @else
                                <span style="background: rgba(245, 158, 11, 0.1); color: #F59E0B; padding: 0.25rem 0.5rem; border-radius: 999px; font-size: 0.75rem; font-weight: bold;">Pending</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" style="text-align: center; padding: 2rem; color: var(--text-muted);">Belum ada karya yang diunggah.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Right Column: Recent System Activities -->
    <div class="dashboard-card" style="display: block; min-height: auto; padding-bottom: 1.5rem; background: var(--bg-card); border-radius: 16px; border: 1px solid var(--border-color); box-shadow: var(--shadow-sm);">
        <h3 style="font-size: 1.15rem; font-weight: 600; margin-bottom: 1.25rem; color: var(--text-main); display: flex; align-items: center; justify-content: space-between;">
            <span style="display: flex; align-items: center; gap: 8px;">
                <i data-feather="clock" style="width: 20px; height: 20px; color: var(--success);"></i>
                Jejak Aktivitas Sistem
            </span>
            <a href="{{ route('activity-logs.index') }}" style="font-size: 0.85rem; color: var(--success); font-weight: 500; text-decoration: none;">Semua Log</a>
        </h3>
        <div style="display: flex; flex-direction: column; gap: 1rem;">
            @forelse($latest_activities as $log)
                <div style="display: flex; align-items: flex-start; gap: 12px; border-bottom: 1px dashed var(--border-color); padding-bottom: 0.75rem;">
                    <div style="background: rgba(79, 70, 229, 0.1); border-radius: 8px; padding: 6px; display: flex; align-items: center; justify-content: center; margin-top: 2px;">
                        <i data-feather="info" style="width: 16px; height: 16px; color: var(--primary);"></i>
                    </div>
                    <div style="flex: 1;">
                        <div style="font-size: 0.85rem; color: var(--text-muted); display: flex; justify-content: space-between; align-items: center; margin-bottom: 2px;">
                            <span style="font-weight: 600; color: var(--text-main);">{{ $log->type }} ({{ $log->action }})</span>
                            <span style="font-size: 0.75rem;">{{ $log->time_ago }}</span>
                        </div>
                        <p style="font-size: 0.85rem; color: var(--text-muted); margin: 0;">{{ $log->deskripsi }}</p>
                        <small style="font-size: 0.75rem; color: var(--primary); font-weight: 500;">Aktor: {{ $log->validasi ?? 'Sistem' }}</small>
                    </div>
                </div>
            @empty
                <p style="text-align: center; padding: 2rem; color: var(--text-muted); margin: 0;">Belum ada aktivitas tercatat.</p>
            @endforelse
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Visitor Chart (Line Chart)
        const visitorData = @json($kunjungan_harian);
        const visitorLabels = visitorData.map(item => item.label);
        const visitorCounts = visitorData.map(item => item.count);

        const ctxVisitor = document.getElementById('visitorChart').getContext('2d');
        new Chart(ctxVisitor, {
            type: 'line',
            data: {
                labels: visitorLabels,
                datasets: [{
                    label: 'Kunjungan',
                    data: visitorCounts,
                    borderColor: '#4F46E5', // Indigo 600
                    backgroundColor: 'rgba(79, 70, 229, 0.08)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#4F46E5',
                    pointBorderColor: '#fff',
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0,
                            color: '#6B7280',
                            font: {
                                family: 'Outfit'
                            }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        ticks: {
                            color: '#6B7280',
                            font: {
                                family: 'Outfit'
                            }
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // Category Chart (Doughnut Chart)
        const categoryData = @json($karya_by_kategori);
        const categoryLabels = categoryData.map(item => item.kategori);
        const categoryCounts = categoryData.map(item => item.count);

        const ctxCategory = document.getElementById('categoryChart').getContext('2d');
        
        if (categoryCounts.length === 0) {
            // Render placeholder if no data is present
            new Chart(ctxCategory, {
                type: 'doughnut',
                data: {
                    labels: ['Belum ada karya'],
                    datasets: [{
                        data: [1],
                        backgroundColor: ['#E5E7EB'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: {
                                font: {
                                    family: 'Outfit'
                                }
                            }
                        }
                    },
                    cutout: '65%'
                }
            });
        } else {
            new Chart(ctxCategory, {
                type: 'doughnut',
                data: {
                    labels: categoryLabels,
                    datasets: [{
                        data: categoryCounts,
                        backgroundColor: [
                            '#4F46E5', // Indigo
                            '#10B981', // Emerald
                            '#F59E0B', // Amber
                            '#3B82F6', // Blue
                            '#EC4899', // Pink
                            '#8B5CF6'  // Purple
                        ],
                        borderWidth: 2,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: {
                                boxWidth: 12,
                                font: {
                                    family: 'Outfit',
                                    size: 12
                                },
                                color: '#4B5563'
                            }
                        }
                    },
                    cutout: '65%'
                }
            });
        }

        // Browser/Device Chart (Doughnut Chart)
        const deviceData = @json($visitor_devices['browsers'] ?? []);
        const deviceLabels = Object.keys(deviceData);
        const deviceCounts = Object.values(deviceData);

        const ctxDevice = document.getElementById('deviceChart').getContext('2d');
        if (deviceCounts.length === 0) {
            new Chart(ctxDevice, {
                type: 'doughnut',
                data: {
                    labels: ['Belum ada data'],
                    datasets: [{
                        data: [1],
                        backgroundColor: ['#E5E7EB'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: {
                                font: {
                                    family: 'Outfit'
                                }
                            }
                        }
                    },
                    cutout: '65%'
                }
            });
        } else {
            new Chart(ctxDevice, {
                type: 'doughnut',
                data: {
                    labels: deviceLabels,
                    datasets: [{
                        data: deviceCounts,
                        backgroundColor: [
                            '#8B5CF6', // Violet / Purple
                            '#3B82F6', // Blue
                            '#EC4899', // Pink
                            '#F59E0B', // Amber / Orange
                            '#10B981', // Emerald
                            '#6B7280'  // Grey
                        ],
                        borderWidth: 2,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: {
                                boxWidth: 12,
                                font: {
                                    family: 'Outfit',
                                    size: 12
                                },
                                color: '#4B5563'
                            }
                        }
                    },
                    cutout: '65%'
                }
            });
        }
    });
</script>
@endpush
@endsection