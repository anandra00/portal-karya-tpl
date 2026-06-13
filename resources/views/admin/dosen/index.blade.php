@extends('admin.layouts.app')

@section('title', 'Daftar Dosen')

@push('styles')
<style>
    .dosen-card {
        background: var(--bg-card);
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border-color);
        border-left: 5px solid var(--primary);
        display: flex;
        align-items: center;
        gap: 1.5rem;
        transition: transform var(--transition-normal), box-shadow var(--transition-normal);
    }
    
    .dosen-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-md);
    }
    
    .dosen-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid var(--bg-main);
        box-shadow: var(--shadow-sm);
    }
    
    .dosen-info {
        flex: 1;
    }
    
    .dosen-info h3 {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--text-main);
        margin-bottom: 0.25rem;
    }
    
    .dosen-info p {
        font-size: 0.9rem;
        color: var(--text-muted);
        margin-bottom: 0.5rem;
    }
    
    .dosen-actions {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }
    
    @media (max-width: 640px) {
        .dosen-card {
            flex-direction: column;
            text-align: center;
        }
        
        .dosen-actions {
            flex-direction: row;
            width: 100%;
            justify-content: center;
            margin-top: 1rem;
        }
    }
</style>
@endpush

@section('content')
<div class="page-header" style="display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h1 class="page-title">Kelola Dosen</h1>
        <p class="page-subtitle">Daftar dosen di program studi Rekayasa Perangkat Lunak SV IPB</p>
    </div>
    <button type="button" class="btn btn-primary" onclick="openModalDosen()">
        <i data-feather="plus-circle"></i> Tambah Dosen
    </button>
</div>

<div class="card-grid" style="grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));">
    @forelse ($dosens as $dosen)
        <div class="dosen-card">
            @if ($dosen->foto)
                <img src="{{ asset('storage/' . $dosen->foto) }}" class="dosen-avatar" alt="{{ $dosen->nama }}">
            @else
                <div class="dosen-avatar" style="background-color: var(--bg-main); display: flex; align-items: center; justify-content: center;">
                    <i data-feather="user" style="color: var(--text-muted); width: 40px; height: 40px;"></i>
                </div>
            @endif

            <div class="dosen-info">
                <h3>{{ $dosen->nama }}</h3>
                <p>{{ $dosen->prodi }}</p>
                <span class="badge badge-success">Aktif</span>
            </div>

            <div class="dosen-actions">
                <button type="button" class="btn btn-secondary" onclick="openModalDosen({{ json_encode($dosen) }})" style="padding: 0.4rem 1rem; font-size: 0.85rem; width: 100%; justify-content: center;">
                    Edit
                </button>
                
                <form action="{{ route('dosen.destroy', $dosen->id) }}" method="POST" class="delete-form" data-name="{{ $dosen->nama }}" style="margin: 0; width: 100%;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" style="padding: 0.4rem 1rem; font-size: 0.85rem; width: 100%; justify-content: center;">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    @empty
        <div class="dashboard-card" style="grid-column: 1 / -1; justify-content: center; text-align: center; padding: 3rem;">
            <div>
                <i data-feather="users" style="width: 48px; height: 48px; color: var(--text-muted); margin-bottom: 1rem;"></i>
                <h3 style="font-size: 1.2rem; color: var(--text-main);">Belum ada data dosen</h3>
                <p style="color: var(--text-muted); margin-top: 0.5rem;">Klik tombol "Tambah Dosen" untuk menambahkan data baru.</p>
            </div>
        </div>
    @endforelse
</div>

<!-- Modal Form Dosen -->
<div class="modal-overlay" id="modalDosen">
    <div class="modal-container">
        <div class="modal-header">
            <h3 class="modal-title" id="modalDosenTitle">Tambah Dosen</h3>
            <button class="close-modal" onclick="closeModalDosen()">
                <i data-feather="x"></i>
            </button>
        </div>
        <form id="formDosen" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_method" id="formDosenMethod" value="POST">
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Nama Dosen *</label>
                    <input type="text" name="nama" id="dosen_nama" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Program Studi *</label>
                    <input type="text" name="prodi" id="dosen_prodi" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">NIP</label>
                    <input type="text" name="nip" id="dosen_nip" class="form-control">
                </div>
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" id="dosen_email" class="form-control">
                </div>
                <div class="form-group">
                    <label class="form-label">Bidang Riset (Research Interest)</label>
                    <input type="text" name="research_interest" id="dosen_research_interest" class="form-control">
                </div>
                <div class="form-group">
                    <label class="form-label">Foto Dosen</label>
                    <input type="file" name="foto" id="dosen_foto" class="form-control" accept="image/*">
                    <small style="color: var(--text-muted); display: block; margin-top: 4px;">Biarkan kosong jika tidak ingin mengubah foto.</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModalDosen()">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    const modalDosen = document.getElementById('modalDosen');
    const formDosen = document.getElementById('formDosen');
    const modalTitle = document.getElementById('modalDosenTitle');
    const methodInput = document.getElementById('formDosenMethod');
    
    function openModalDosen(dosen = null) {
        if (dosen) {
            modalTitle.textContent = 'Edit Dosen';
            formDosen.action = `/admin/dosen/${dosen.id}`;
            methodInput.value = 'PUT';
            
            document.getElementById('dosen_nama').value = dosen.nama || '';
            document.getElementById('dosen_prodi').value = dosen.prodi || '';
            document.getElementById('dosen_nip').value = dosen.nip || '';
            document.getElementById('dosen_email').value = dosen.email || '';
            document.getElementById('dosen_research_interest').value = dosen.research_interest || '';
        } else {
            modalTitle.textContent = 'Tambah Dosen';
            formDosen.action = `{{ route('dosen.store') }}`;
            methodInput.value = 'POST';
            formDosen.reset();
        }
        
        modalDosen.classList.add('show');
    }
    
    function closeModalDosen() {
        modalDosen.classList.remove('show');
    }
</script>
@endpush
@endsection