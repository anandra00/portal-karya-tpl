@extends('layouts.app')

@section('title', 'Unggah Karya')



@section('hero')
@include('partials.hero', ['title' => 'Unggah Karya Mahasiswa', 'subtitle' => 'Bagikan Karya Terbaikmu'])
@endsection

@section('content')
<main class="py-20 bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="fade-in-up">
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 p-8 sm:p-10 relative overflow-hidden">
                {{-- Decorative corner --}}
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-bl from-indigo-50 dark:from-indigo-950/20 to-transparent rounded-bl-full"></div>

                @php
                    $email = Auth::user()->email ?? '';
                    $isIpbEmail = str_ends_with($email, '@apps.ipb.ac.id');
                    $isAdmin = Auth::check() && Auth::user()->role === 'admin';
                    $canUpload = $isIpbEmail || $isAdmin;
                @endphp

                @if (!$canUpload)
                    <div class="text-center py-12 relative z-10">
                        <div class="w-20 h-20 bg-red-50 dark:bg-red-900/30 rounded-2xl flex items-center justify-center mx-auto mb-6 text-red-500">
                            <i class="bi bi-shield-slash-fill text-4xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Akses Terbatas</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-8 leading-relaxed max-w-md mx-auto">
                            Hanya mahasiswa dengan alamat email berdomain <strong class="text-indigo-600 dark:text-indigo-400 font-semibold">@apps.ipb.ac.id</strong> yang diizinkan untuk mengunggah karya di platform ini.
                        </p>
                        <a href="{{ route('home') }}" class="inline-flex items-center justify-center px-6 py-3 text-base font-bold rounded-xl text-white bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 transition-all shadow-md hover:shadow-lg">
                            <i class="bi bi-arrow-left mr-2"></i> Kembali ke Beranda
                        </a>
                    </div>
                @else
                    {{-- Form Header --}}
                    <div class="relative z-10 mb-8">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-10 h-10 bg-indigo-100 dark:bg-indigo-900/40 rounded-xl flex items-center justify-center text-indigo-600 dark:text-indigo-400">
                                <i class="bi bi-cloud-arrow-up-fill text-xl"></i>
                            </div>
                            <h3 class="text-2xl sm:text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">Form Unggah Karya</h3>
                        </div>
                        <p class="text-gray-500 dark:text-gray-400 text-sm ml-[52px]">Isi semua field yang ditandai <span class="text-red-500 font-bold">*</span> untuk mengunggah karya.</p>
                    </div>

                    {{-- Alpine Wrapper for Stepper --}}
                    <div x-data="{ 
                        step: 1, 
                        submitting: false,
                        validateStep1() {
                            const j = document.getElementById('judul');
                            const k = document.getElementById('kategori');
                            const t = document.getElementById('tim_pembuat');
                            const y = document.getElementById('tahun');
                            if(!j.checkValidity()) { j.reportValidity(); return false; }
                            if(!k.checkValidity()) { k.reportValidity(); return false; }
                            if(!t.checkValidity()) { t.reportValidity(); return false; }
                            if(!y.checkValidity()) { y.reportValidity(); return false; }
                            return true;
                        },
                        validateStep2() {
                            const d = document.getElementById('deskripsi');
                            if(!d.checkValidity()) { d.reportValidity(); return false; }
                            return true;
                        }
                    }">
                        {{-- Progress Steps --}}
                        <div class="flex items-center justify-between mb-10 px-4">
                            <!-- Step 1 Indicator -->
                            <div class="flex items-center gap-2">
                                <span class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold transition-all duration-300"
                                      :class="step === 1 ? 'bg-indigo-600 text-white ring-4 ring-indigo-500/20' : (step > 1 ? 'bg-green-500 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400')">
                                    <template x-if="step > 1">
                                        <i class="bi bi-check-lg"></i>
                                    </template>
                                    <template x-if="step === 1">
                                        <span>1</span>
                                    </template>
                                </span>
                                <span class="text-sm font-semibold hidden sm:inline transition-colors duration-300"
                                      :class="step === 1 ? 'text-indigo-600 dark:text-indigo-400' : (step > 1 ? 'text-green-500 dark:text-green-400' : 'text-gray-400 dark:text-gray-500')">Informasi</span>
                            </div>
                            
                            <!-- Connector 1-2 -->
                            <div class="flex-1 h-0.5 bg-gray-200 dark:bg-gray-700 mx-2 rounded-full relative overflow-hidden">
                                <div class="absolute inset-y-0 left-0 bg-indigo-600 transition-all duration-500" :style="step > 1 ? 'width: 100%' : 'width: 0%'"></div>
                            </div>
                            
                            <!-- Step 2 Indicator -->
                            <div class="flex items-center gap-2">
                                <span class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold transition-all duration-300"
                                      :class="step === 2 ? 'bg-indigo-600 text-white ring-4 ring-indigo-500/20' : (step > 2 ? 'bg-green-500 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400')">
                                    <template x-if="step > 2">
                                        <i class="bi bi-check-lg"></i>
                                    </template>
                                    <template x-if="step <= 2">
                                        <span>2</span>
                                    </template>
                                </span>
                                <span class="text-sm font-semibold hidden sm:inline transition-colors duration-300"
                                      :class="step === 2 ? 'text-indigo-600 dark:text-indigo-400' : (step > 2 ? 'text-green-500 dark:text-green-400' : 'text-gray-400 dark:text-gray-500')">Detail</span>
                            </div>
                            
                            <!-- Connector 2-3 -->
                            <div class="flex-1 h-0.5 bg-gray-200 dark:bg-gray-700 mx-2 rounded-full relative overflow-hidden">
                                <div class="absolute inset-y-0 left-0 bg-indigo-600 transition-all duration-500" :style="step > 2 ? 'width: 100%' : 'width: 0%'"></div>
                            </div>
                            
                            <!-- Step 3 Indicator -->
                            <div class="flex items-center gap-2">
                                <span class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold transition-all duration-300"
                                      :class="step === 3 ? 'bg-indigo-600 text-white ring-4 ring-indigo-500/20' : 'bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400'">
                                    <span>3</span>
                                </span>
                                <span class="text-sm font-semibold hidden sm:inline transition-colors duration-300"
                                      :class="step === 3 ? 'text-indigo-600 dark:text-indigo-400' : 'text-gray-400 dark:text-gray-500'">Media</span>
                            </div>
                        </div>

                        {{-- Pesan Error --}}
                        @if ($errors->any())
                            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800/50 rounded-xl p-5 mb-8 relative animate-pulse" role="alert">
                                <div class="flex items-start gap-3">
                                    <i class="bi bi-exclamation-triangle-fill text-red-500 text-lg mt-0.5"></i>
                                    <div>
                                        <strong class="text-red-800 dark:text-red-400 font-bold block mb-1">Oops! Ada beberapa masalah:</strong>
                                        <ul class="list-disc list-inside text-red-700 dark:text-red-300 space-y-0.5 text-sm">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <form action="{{ route('karya.store') }}" 
                              method="POST" 
                              enctype="multipart/form-data" 
                              class="space-y-6"
                              @submit="if(submitting) { $event.preventDefault(); } else { submitting = true; }"
                              @keydown.enter="if (step < 3) { $event.preventDefault(); }">
                            @csrf
                            
                            {{-- ==================== STEP 1: INFORMASI ==================== --}}
                            <div x-show="step === 1" class="space-y-6" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                                {{-- 1. Judul Karya --}}
                                <div class="floating-label-group mb-6">
                                    <input type="text" 
                                           class="w-full px-4 py-3.5 rounded-xl border {{ $errors->has('judul') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-200 dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500' }} bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition-all focus:shadow-[0_0_20px_rgba(99,102,241,0.1)] outline-none" 
                                           id="judul" 
                                           name="judul" 
                                           value="{{ old('judul') }}" 
                                           required 
                                           placeholder=" ">
                                    <label for="judul" class="absolute left-4 top-3.5 text-sm font-semibold text-gray-500 dark:text-gray-400 transition-all pointer-events-none">Judul Karya <span class="text-red-500">*</span></label>
                                    @error('judul')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center gap-1"><i class="bi bi-exclamation-circle text-xs"></i> {{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- 2. Kategori --}}
                                <div>
                                    <label for="kategori" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Kategori <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <select class="w-full px-4 py-3.5 rounded-xl border {{ $errors->has('kategori') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-200 dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500' }} bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition-all focus:shadow-[0_0_20px_rgba(99,102,241,0.1)] appearance-none outline-none" 
                                                id="kategori" 
                                                name="kategori" 
                                                required>
                                            <option value="">Pilih Kategori</option>
                                            @foreach($categories as $kat)
                                                <option value="{{ $kat->name }}" {{ old('kategori') == $kat->name ? 'selected' : '' }}>{{ $kat->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-gray-400">
                                            <i class="bi bi-chevron-down"></i>
                                        </div>
                                    </div>
                                    @error('kategori')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center gap-1"><i class="bi bi-exclamation-circle text-xs"></i> {{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- 3. Nama Tim/Pembuat --}}
                                <div class="floating-label-group mb-6">
                                    <input type="text" 
                                           class="w-full px-4 py-3.5 rounded-xl border {{ $errors->has('tim_pembuat') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-200 dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500' }} bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition-all focus:shadow-[0_0_20px_rgba(99,102,241,0.1)] outline-none" 
                                           id="tim_pembuat" 
                                           name="tim_pembuat" 
                                           value="{{ old('tim_pembuat') }}" 
                                           required 
                                           placeholder=" ">
                                    <label for="tim_pembuat" class="absolute left-4 top-3.5 text-sm font-semibold text-gray-500 dark:text-gray-400 transition-all pointer-events-none">Nama Tim/Pembuat <span class="text-red-500">*</span></label>
                                    @error('tim_pembuat')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center gap-1"><i class="bi bi-exclamation-circle text-xs"></i> {{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                    {{-- 4. Tahun --}}
                                    <div>
                                        <label for="tahun" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Tahun <span class="text-red-500">*</span></label>
                                        <div class="relative">
                                            <select class="w-full px-4 py-3.5 rounded-xl border {{ $errors->has('tahun') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-200 dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500' }} bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition-all focus:shadow-[0_0_20px_rgba(99,102,241,0.1)] appearance-none outline-none" 
                                                    id="tahun" 
                                                    name="tahun" 
                                                    required>
                                                <option value="">Pilih Tahun</option>
                                                @for ($year = date('Y'); $year >= 2020; $year--)
                                                    <option value="{{ $year }}" {{ old('tahun', date('Y')) == $year ? 'selected' : '' }}>
                                                        {{ $year }}
                                                    </option>
                                                @endfor
                                            </select>
                                            <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-gray-400">
                                                <i class="bi bi-chevron-down"></i>
                                            </div>
                                        </div>
                                        @error('tahun')
                                            <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center gap-1"><i class="bi bi-exclamation-circle text-xs"></i> {{ $message }}</p>
                                        @enderror
                                    </div>

                                    {{-- 5. Email --}}
                                    <div class="floating-label-group">
                                        <input type="email" 
                                               class="w-full px-4 py-3.5 rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-500 dark:text-gray-400 cursor-not-allowed outline-none" 
                                               id="email" 
                                               name="email" 
                                               value="{{ old('email', Auth::user()->email ?? '') }}" 
                                               required 
                                               readonly
                                               placeholder=" ">
                                        <label for="email" class="absolute left-4 top-3.5 text-sm font-semibold text-gray-500 dark:text-gray-400 transition-all pointer-events-none">Email <span class="text-red-500">*</span></label>
                                        @error('email')
                                            <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center gap-1"><i class="bi bi-exclamation-circle text-xs"></i> {{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- ==================== STEP 2: DETAIL KARYA ==================== --}}
                            <div x-show="step === 2" class="space-y-6" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                                {{-- 6. Deskripsi --}}
                                <div class="floating-label-group mb-6">
                                    <textarea class="w-full px-4 py-3.5 rounded-xl border {{ $errors->has('deskripsi') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-200 dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500' }} bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition-all focus:shadow-[0_0_20px_rgba(99,102,241,0.1)] resize-y outline-none" 
                                              id="deskripsi" 
                                              name="deskripsi" 
                                              rows="5" 
                                              required 
                                              placeholder=" ">{{ old('deskripsi') }}</textarea>
                                    <label for="deskripsi" class="absolute left-4 top-3.5 text-sm font-semibold text-gray-500 dark:text-gray-400 transition-all pointer-events-none">Deskripsi Karya <span class="text-red-500">*</span></label>
                                    @error('deskripsi')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center gap-1"><i class="bi bi-exclamation-circle text-xs"></i> {{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- 7. Link Pengumpulan --}}
                                <div class="floating-label-group mb-6">
                                    <input type="url" 
                                           class="w-full px-4 py-3.5 rounded-xl border {{ $errors->has('link') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-200 dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500' }} bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition-all focus:shadow-[0_0_20px_rgba(99,102,241,0.1)] outline-none" 
                                           id="link" 
                                           name="link" 
                                           value="{{ old('link') }}" 
                                           placeholder=" ">
                                    <label for="link" class="absolute left-4 top-3.5 text-sm font-semibold text-gray-500 dark:text-gray-400 transition-all pointer-events-none">Pengumpulan (Link Google Drive/GitHub)</label>
                                    @error('link')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center gap-1"><i class="bi bi-exclamation-circle text-xs"></i> {{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- 7b. Upload PDF --}}
                                <div>
                                    <label for="file_karya" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Dokumen Laporan/Poster (PDF) <span class="text-sm font-normal text-gray-500">(Opsional)</span></label>
                                    <div class="relative flex items-center">
                                        <input type="file" 
                                               class="w-full px-4 py-3 rounded-xl border {{ $errors->has('file_karya') ? 'border-red-500' : 'border-gray-200 dark:border-gray-600' }} bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition-all file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 dark:file:bg-indigo-900/30 file:text-indigo-600 dark:file:text-indigo-400 hover:file:bg-indigo-100" 
                                               id="file_karya" 
                                               name="file_karya" 
                                               accept="application/pdf">
                                    </div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-2 flex items-center gap-1"><i class="bi bi-info-circle"></i> Format PDF, maksimal 10MB</p>
                                    @error('file_karya')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center gap-1"><i class="bi bi-exclamation-circle text-xs"></i> {{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            {{-- ==================== STEP 3: MEDIA & SCREENSHOT ==================== --}}
                            <div x-show="step === 3" class="space-y-6" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                                {{-- 8. Upload Gambar — Drag & Drop with Preview --}}
                                <div x-data="{ 
                                    fileName: '', 
                                    preview: null,
                                    dragging: false,
                                    handleFile(e) {
                                        const file = e.target.files[0] || (e.dataTransfer && e.dataTransfer.files[0]);
                                        if (file) {
                                            this.fileName = file.name;
                                            const reader = new FileReader();
                                            reader.onload = (e) => { this.preview = e.target.result; };
                                            reader.readAsDataURL(file);
                                            if (e.dataTransfer) {
                                                document.getElementById('gambar').files = e.dataTransfer.files;
                                            }
                                        }
                                    }
                                }">
                                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Screenshot/Gambar Karya <span class="text-red-500">*</span></label>
                                    
                                    <div class="mt-1 relative"
                                         @dragover.prevent="dragging = true"
                                         @dragleave.prevent="dragging = false"
                                         @drop.prevent="dragging = false; handleFile($event)">
                                        {{-- Preview --}}
                                        <template x-if="preview">
                                            <div class="relative mb-4 rounded-2xl overflow-hidden border-2 border-indigo-500 dark:border-indigo-400 shadow-md max-h-[300px]">
                                                <img :src="preview" class="w-full h-full object-cover">
                                                <div class="absolute bottom-0 inset-x-0 bg-gradient-to-t from-black/70 via-black/40 to-transparent p-4 flex justify-between items-center">
                                                    <p class="text-white text-sm font-bold truncate pr-4" x-text="fileName"></p>
                                                    <button type="button" @click="preview = null; fileName = ''; document.getElementById('gambar').value = ''" 
                                                            class="bg-red-600 hover:bg-red-700 text-white rounded-lg px-3 py-1.5 text-xs font-bold transition-all shadow">
                                                        <i class="bi bi-trash mr-1"></i> Hapus
                                                    </button>
                                                </div>
                                            </div>
                                        </template>

                                        <label for="gambar" 
                                               class="flex flex-col items-center justify-center px-6 py-10 border-2 border-dashed rounded-2xl cursor-pointer transition-all duration-300"
                                               :class="dragging 
                                                   ? 'border-indigo-500 bg-indigo-50 dark:bg-indigo-950/30' 
                                                   : '{{ $errors->has('gambar') ? 'border-red-300 bg-red-50/20' : 'border-gray-300 dark:border-gray-600 bg-gray-50/50 dark:bg-gray-750' }} hover:bg-indigo-50/30 dark:hover:bg-indigo-950/10 hover:border-indigo-400'">
                                            <div class="space-y-2 text-center">
                                                <div class="w-14 h-14 mx-auto rounded-2xl bg-indigo-100 dark:bg-indigo-900/40 flex items-center justify-center text-indigo-600 dark:text-indigo-400 mb-2 group-hover:scale-110 transition-transform">
                                                    <i class="bi bi-images text-2xl"></i>
                                                </div>
                                                <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                                                    <span class="text-indigo-600 dark:text-indigo-400" x-text="fileName || 'Klik untuk pilih file atau seret kemari'"></span>
                                                </p>
                                                <p class="text-xs text-gray-400 dark:text-gray-500">PNG, JPG, JPEG (Maksimal 2MB)</p>
                                            </div>
                                            <input id="gambar" name="preview_karya" type="file" class="sr-only" accept="image/*" required @change="handleFile($event)">
                                        </label>
                                    </div>

                                    @error('gambar')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center gap-1"><i class="bi bi-exclamation-circle text-xs"></i> {{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            {{-- ==================== NAVIGATION BUTTONS ==================== --}}
                            <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-700 mt-8">
                                <div>
                                    <!-- Back Button -->
                                    <button type="button" 
                                            x-show="step > 1" 
                                            @click="step--" 
                                            class="px-6 py-3 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-white font-bold rounded-xl transition-all flex items-center text-sm">
                                        <i class="bi bi-arrow-left mr-2"></i> Sebelumnya
                                    </button>
                                    <!-- Cancel Button -->
                                    <a href="{{ route('home') }}" 
                                       x-show="step === 1"
                                       class="px-6 py-3 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-white font-bold rounded-xl transition-all flex items-center text-sm">
                                        <i class="bi bi-x-circle mr-2"></i> Batal
                                    </a>
                                </div>
                                
                                <div>
                                    <!-- Next Button -->
                                    <button type="button" 
                                            x-show="step < 3" 
                                            @click="if(step === 1 ? validateStep1() : validateStep2()) step++" 
                                            class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 text-white font-bold rounded-xl shadow-md hover:shadow-lg transition-all flex items-center text-sm">
                                        Selanjutnya <i class="bi bi-arrow-right ml-2"></i>
                                    </button>
                                    <!-- Submit Button -->
                                    <button type="submit" 
                                            x-show="step === 3" 
                                            :disabled="submitting"
                                            class="px-8 py-3 bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 text-white font-bold rounded-xl shadow-md hover:shadow-lg transition-all flex items-center justify-center disabled:opacity-50 text-sm"
                                            :class="submitting ? 'cursor-not-allowed' : 'hover:-translate-y-0.5'">
                                        <template x-if="!submitting">
                                            <span class="flex items-center"><i class="bi bi-upload mr-2"></i> Unggah Karya</span>
                                        </template>
                                        <template x-if="submitting">
                                            <span class="flex items-center">
                                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                </svg>
                                                Mengunggah...
                                            </span>
                                        </template>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</main>
@endsection