@extends('layouts.app')
@section('title', 'Activity Log')

@push('styles')
<style>
    body { background-color: var(--bg-light); }
</style>
@endpush

@section('content')
<div class="container-fluid py-5 mt-5">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-lg-3 col-md-4 mb-4">
            @include('admin.partials.sidebar')
        </div>

        <!-- Content -->
        <div class="col-lg-9 col-md-8">
            <div class="card premium-card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 py-3 d-flex align-items-center justify-content-between">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-clock-history me-2 text-primary"></i>Activity Log (Jejak Audit)</h5>
                </div>
                
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Tipe</th>
                                    <th>Aksi</th>
                                    <th>Deskripsi</th>
                                    <th>Aktor</th>
                                    <th>Waktu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($logs as $log)
                                <tr>
                                    <td class="ps-4">
                                        <span class="badge bg-secondary">{{ $log->type }}</span>
                                    </td>
                                    <td><strong>{{ $log->action }}</strong></td>
                                    <td>{{ $log->deskripsi }}</td>
                                    <td><i class="bi bi-person-fill me-1"></i>{{ $log->validasi ?? 'Sistem' }}</td>
                                    <td><small class="text-muted">{{ $log->created_at->diffForHumans() }}</small></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">Belum ada aktivitas tercatat.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                
                @if($logs->hasPages())
                <div class="card-footer bg-white border-0 py-3 d-flex justify-content-center">
                    {{ $logs->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
