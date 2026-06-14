@extends('admin.layouts.app')

@section('title', 'Mata Kuliah')

@push('styles')
<style>
    /* Slider Semester */
    .semester-slider-container {
      margin-bottom: 1.5rem;
    }

    .slider-wrapper {
      display: flex;
      align-items: center;
      gap: 1rem;
    }

    .slider-arrow {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      width: 40px;
      height: 40px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: all 0.3s;
      box-shadow: var(--shadow-sm);
      flex-shrink: 0;
      color: var(--primary);
      font-size: 1.2rem;
    }

    .slider-arrow:hover:not(:disabled) {
      background: var(--primary);
      color: white;
    }

    .slider-arrow:disabled {
      opacity: 0.3;
      cursor: not-allowed;
    }

    .semester-tabs-overflow {
      overflow: hidden;
      flex: 1;
    }

    .semester-tabs {
      display: flex;
      gap: 0.75rem;
      transition: transform 0.3s ease;
    }

    .semester-tab {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      color: var(--text-muted);
      padding: 0.75rem 1.5rem;
      border-radius: 10px;
      cursor: pointer;
      transition: all 0.3s;
      font-weight: 600;
      white-space: nowrap;
      flex-shrink: 0;
      min-width: 130px;
      text-align: center;
    }

    .semester-tab:hover {
      border-color: var(--primary);
      color: var(--primary);
    }

    .semester-tab.active {
      background: var(--primary);
      color: white;
      border-color: var(--primary);
      box-shadow: var(--shadow-md);
    }

    .semester-content {
      display: none;
    }

    .semester-content.active {
      display: block;
      animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(5px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endpush

@section('content')
<div class="page-header" style="display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h1 class="page-title">Mata Kuliah</h1>
        <p class="page-subtitle">Kelola kurikulum mata kuliah per semester</p>
    </div>
    <button type="button" class="btn btn-primary" onclick="openModalTambah()">
        <i data-feather="plus-circle"></i> Tambah Mata Kuliah
    </button>
</div>

<div class="semester-slider-container">
    <div class="slider-wrapper">
        <button class="slider-arrow" id="prevBtn" onclick="slideLeft()">
            <i data-feather="chevron-left"></i>
        </button>
        
        <div class="semester-tabs-overflow">
            <div class="semester-tabs" id="semesterTabs">
                @for($i = 1; $i <= 8; $i++)
                    <div class="semester-tab {{ $i == 1 ? 'active' : '' }}" onclick="showSemester({{ $i }})">
                        Semester {{ $i }}
                    </div>
                @endfor
            </div>
        </div>

        <button class="slider-arrow" id="nextBtn" onclick="slideRight()">
            <i data-feather="chevron-right"></i>
        </button>
    </div>
</div>

@for($semester = 1; $semester <= 8; $semester++)
<div class="semester-content {{ $semester == 1 ? 'active' : '' }}" id="semester{{ $semester }}">
    <div class="table-container">
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th style="width: 15%;">Kode</th>
                        <th style="width: 40%;">Mata Kuliah</th>
                        <th style="width: 15%;">SKS (T-P)</th>
                        <th style="width: 25%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $semesterData = $matakuliahs->where('semester', $semester);
                        $no = 1;
                    @endphp
                    
                    @forelse($semesterData as $mk)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td><strong>{{ $mk->kode_matkul }}</strong></td>
                        <td>{{ $mk->nama_matkul }}</td>
                        <td>{{ $mk->sks_teori }} Teori - {{ $mk->sks_praktik }} Praktik</td>
                        <td>
                            <div class="action-group">
                                <button type="button" class="btn btn-secondary" onclick="openModalEdit({{ json_encode($mk) }})" style="padding: 0.4rem 0.8rem; font-size: 0.85rem;">
                                    Edit
                                </button>
                                
                                <form action="{{ route('admin.matakuliah.destroy', $mk->id) }}" method="POST" class="delete-form" data-name="{{ $mk->nama_matkul }}" style="margin: 0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" style="padding: 0.4rem 0.8rem; font-size: 0.85rem;">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 3rem;">
                            <i data-feather="book" style="width: 48px; height: 48px; color: var(--text-muted); margin-bottom: 1rem;"></i>
                            <p style="color: var(--text-muted); font-size: 1rem;">Belum ada mata kuliah di Semester {{ $semester }}</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endfor

<!-- Modal Tambah/Edit Mata Kuliah -->
<div class="modal-overlay" id="modalMatkul">
    <div class="modal-container">
        <div class="modal-header">
            <h3 class="modal-title" id="modalMatkulTitle">Tambah Mata Kuliah</h3>
            <button class="close-modal" onclick="closeModalMatkul()">
                <i data-feather="x"></i>
            </button>
        </div>
        <form id="formMatkul" method="POST">
            @csrf
            <input type="hidden" name="_method" id="formMatkulMethod" value="POST">
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Kode Mata Kuliah *</label>
                    <input type="text" name="kode_matkul" id="mk_kode" class="form-control" placeholder="Contoh: TPL1101" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Nama Mata Kuliah *</label>
                    <input type="text" name="nama_matkul" id="mk_nama" class="form-control" placeholder="Contoh: Berpikir Komputasional" required>
                </div>
                <div style="display: flex; gap: 1rem; margin-bottom: 1.25rem;">
                    <div class="form-group" style="flex: 1; margin-bottom: 0;">
                        <label class="form-label">SKS Teori *</label>
                        <input type="number" name="sks_teori" id="mk_teori" class="form-control" placeholder="Contoh: 2" min="0" required>
                    </div>
                    <div class="form-group" style="flex: 1; margin-bottom: 0;">
                        <label class="form-label">SKS Praktik *</label>
                        <input type="number" name="sks_praktik" id="mk_praktik" class="form-control" placeholder="Contoh: 1" min="0" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Semester *</label>
                    <select name="semester" id="mk_semester" class="form-control" required style="appearance: auto; height: 42px;">
                        <option value="">-- Pilih Semester --</option>
                        @for($i = 1; $i <= 8; $i++)
                            <option value="{{ $i }}">Semester {{ $i }}</option>
                        @endfor
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModalMatkul()">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let currentSlide = 0;
    const tabWidth = 146; // 130px width + 16px gap

    function showSemester(semester) {
        document.querySelectorAll('.semester-content').forEach(c => c.classList.remove('active'));
        document.querySelectorAll('.semester-tab').forEach(t => t.classList.remove('active'));

        document.getElementById('semester' + semester).classList.add('active');
        document.querySelectorAll('.semester-tab')[semester - 1].classList.add('active');

        currentSlide = semester - 1;
        updateSliderPosition();
    }

    function slideLeft() {
        if (currentSlide > 0) {
            currentSlide--;
            updateSliderPosition();
        }
    }

    function slideRight() {
        if (currentSlide < 7) {
            currentSlide++;
            updateSliderPosition();
        }
    }

    function updateSliderPosition() {
        const tabs = document.getElementById('semesterTabs');
        tabs.style.transform = `translateX(-${currentSlide * tabWidth}px)`;

        document.getElementById('prevBtn').disabled = currentSlide === 0;
        document.getElementById('nextBtn').disabled = currentSlide === 7;
    }

    // Initialize
    updateSliderPosition();

    // Modal logic
    const modalMatkul = document.getElementById('modalMatkul');
    const formMatkul = document.getElementById('formMatkul');
    const modalTitle = document.getElementById('modalMatkulTitle');
    const methodInput = document.getElementById('formMatkulMethod');
    
    function openModalTambah() {
        modalTitle.textContent = 'Tambah Mata Kuliah';
        formMatkul.action = `{{ route('admin.matakuliah.store') }}`;
        methodInput.value = 'POST';
        formMatkul.reset();
        modalMatkul.classList.add('show');
    }

    function openModalEdit(mk) {
        modalTitle.textContent = 'Edit Mata Kuliah';
        formMatkul.action = `/admin/matakuliah/${mk.id}`;
        methodInput.value = 'PUT';
        
        document.getElementById('mk_kode').value = mk.kode_matkul;
        document.getElementById('mk_nama').value = mk.nama_matkul;
        document.getElementById('mk_teori').value = mk.sks_teori;
        document.getElementById('mk_praktik').value = mk.sks_praktik;
        document.getElementById('mk_semester').value = mk.semester;
        
        modalMatkul.classList.add('show');
    }

    function closeModalMatkul() {
        modalMatkul.classList.remove('show');
    }
</script>
@endpush