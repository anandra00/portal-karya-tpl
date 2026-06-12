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
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
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
                            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $mk->id }}" style="padding: 0.4rem 0.8rem; font-size: 0.85rem;">
                                Edit
                            </button>
                            
                            <form action="{{ route('admin.matakuliah.destroy', $mk->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus mata kuliah ini?');" style="margin: 0;">
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
@endfor

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border: none; border-radius: 12px; box-shadow: var(--shadow-lg);">
            <div class="modal-header" style="border-bottom: 1px solid var(--border-color); background: var(--bg-main);">
                <h5 class="modal-title" style="font-weight: 600;">Tambah Mata Kuliah</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.matakuliah.store') }}" method="POST">
                @csrf
                <div class="modal-body" style="padding: 1.5rem;">
                    <div class="mb-3">
                        <label class="form-label" style="font-weight: 500;">Kode Mata Kuliah <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="kode_matkul" placeholder="Contoh: TPL1101" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" style="font-weight: 500;">Nama Mata Kuliah <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nama_matkul" placeholder="Contoh: Berpikir Komputasional" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" style="font-weight: 500;">SKS Teori <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="sks_teori" placeholder="Contoh: 2" min="0" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" style="font-weight: 500;">SKS Praktik <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="sks_praktik" placeholder="Contoh: 1" min="0" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" style="font-weight: 500;">Semester <span class="text-danger">*</span></label>
                        <select class="form-select" name="semester" required>
                            <option value="">-- Pilih Semester --</option>
                            @for($i = 1; $i <= 8; $i++)
                                <option value="{{ $i }}">Semester {{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid var(--border-color);">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->
@foreach($matakuliahs as $mk)
<div class="modal fade" id="modalEdit{{ $mk->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border: none; border-radius: 12px; box-shadow: var(--shadow-lg);">
            <div class="modal-header" style="border-bottom: 1px solid var(--border-color); background: var(--bg-main);">
                <h5 class="modal-title" style="font-weight: 600;">Edit Mata Kuliah</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.matakuliah.update', $mk->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body" style="padding: 1.5rem;">
                    <div class="mb-3">
                        <label class="form-label" style="font-weight: 500;">Kode Mata Kuliah <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="kode_matkul" value="{{ $mk->kode_matkul }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" style="font-weight: 500;">Nama Mata Kuliah <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nama_matkul" value="{{ $mk->nama_matkul }}" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" style="font-weight: 500;">SKS Teori <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="sks_teori" value="{{ $mk->sks_teori }}" min="0" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" style="font-weight: 500;">SKS Praktik <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="sks_praktik" value="{{ $mk->sks_praktik }}" min="0" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" style="font-weight: 500;">Semester <span class="text-danger">*</span></label>
                        <select class="form-select" name="semester" required>
                            @for($i = 1; $i <= 8; $i++)
                                <option value="{{ $i }}" {{ $mk->semester == $i ? 'selected' : '' }}>Semester {{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid var(--border-color);">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" style="background-color: var(--warning); color: white;">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

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
</script>
@endpush