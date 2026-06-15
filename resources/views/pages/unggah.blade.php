@extends('layouts.app')

@section('title', 'Unggah Karya')



@section('hero')
@include('partials.hero', ['title' => 'Unggah Karya Mahasiswa', 'subtitle' => 'Bagikan Karya Terbaikmu'])
@endsection

@section('content')
<main class="py-20 bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="fade-in-up">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-8 sm:p-10">
                @php
                    $email = Auth::user()->email ?? '';
                    $isIpbEmail = str_ends_with($email, '@apps.ipb.ac.id');
                    $isAdmin = Auth::check() && Auth::user()->role === 'admin';
                    $canUpload = $isIpbEmail || $isAdmin;
                @endphp

                @if (!$canUpload)
                    <div class="text-center py-12">
                        <div class="w-20 h-20 bg-red-50 dark:bg-red-900/30 rounded-full flex items-center justify-center mx-auto mb-6 text-red-500">
                            <i class="bi bi-shield-slash-fill text-4xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Akses Terbatas</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-8 leading-relaxed max-w-md mx-auto">
                            Hanya mahasiswa dengan alamat email berdomain <strong class="text-indigo-600 dark:text-indigo-400 font-semibold">@apps.ipb.ac.id</strong> yang diizinkan untuk mengunggah karya di platform ini.
                        </p>
                        <a href="{{ route('home') }}" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-bold rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors shadow-sm">
                            Kembali ke Beranda
                        </a>
                    </div>
                @else
                    <h3 class="text-2xl sm:text-3xl font-extrabold text-gray-900 dark:text-white mb-8 tracking-tight">Form Unggah Karya</h3>
                
                {{-- Pesan Error --}}
                @if ($errors->any())
                    <div class="bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 rounded-xl p-6 mb-8 relative" role="alert">
                        <strong class="text-red-800 dark:text-red-400 font-bold block mb-2">Oops! Ada beberapa masalah:</strong>
                        <ul class="list-disc list-inside text-red-700 dark:text-red-300 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif


                
                <form action="{{ route('karya.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    
                    {{-- 1. Judul Karya --}}
                    <div>
                        <label for="judul" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Judul Karya <span class="text-red-500">*</span></label>
                        <input type="text" 
                               class="w-full px-4 py-3 rounded-xl border {{ $errors->has('judul') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500' }} bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition-colors" 
                               id="judul" 
                               name="judul" 
                               value="{{ old('judul') }}" 
                               required 
                               placeholder="Masukkan judul karya">
                        @error('judul')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- 2. Kategori --}}
                    <div>
                        <label for="kategori" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Kategori <span class="text-red-500">*</span></label>
                        <select class="w-full px-4 py-3 rounded-xl border {{ $errors->has('kategori') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500' }} bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition-colors appearance-none" 
                                id="kategori" 
                                name="kategori" 
                                required>
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $kat)
                                <option value="{{ $kat->name }}" {{ old('kategori') == $kat->name ? 'selected' : '' }}>{{ $kat->name }}</option>
                            @endforeach
                        </select>
                        @error('kategori')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- 3. Nama Tim/Pembuat --}}
                    <div>
                        <label for="tim_pembuat" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Nama Tim/Pembuat <span class="text-red-500">*</span></label>
                        <input type="text" 
                               class="w-full px-4 py-3 rounded-xl border {{ $errors->has('tim_pembuat') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500' }} bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition-colors" 
                               id="tim_pembuat" 
                               name="tim_pembuat" 
                               value="{{ old('tim_pembuat') }}" 
                               required 
                               placeholder="Contoh: Tim StockNest">
                        @error('tim_pembuat')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        {{-- 4. Tahun --}}
                        <div>
                            <label for="tahun" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Tahun <span class="text-red-500">*</span></label>
                            <select class="w-full px-4 py-3 rounded-xl border {{ $errors->has('tahun') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500' }} bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition-colors appearance-none" 
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
                            @error('tahun')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- 5. Email --}}
                        <div>
                            <label for="email" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Email <span class="text-red-500">*</span></label>
                            <input type="email" 
                                   class="w-full px-4 py-3 rounded-xl border {{ $errors->has('email') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500' }} bg-gray-100 dark:bg-gray-600 text-gray-600 dark:text-gray-400 cursor-not-allowed transition-colors" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email', Auth::user()->email ?? '') }}" 
                                   required 
                                   readonly
                                   placeholder="pembuat@gmail.com">
                            @error('email')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- 6. Deskripsi --}}
                    <div>
                        <label for="deskripsi" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Deskripsi Karya <span class="text-red-500">*</span></label>
                        <textarea class="w-full px-4 py-3 rounded-xl border {{ $errors->has('deskripsi') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500' }} bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition-colors resize-y" 
                                  id="deskripsi" 
                                  name="deskripsi" 
                                  rows="5" 
                                  required 
                                  placeholder="Jelaskan detail tentang karyamu...">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- 7. Link Pengumpulan --}}
                    <div>
                        <label for="link" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Pengumpulan (Link)</label>
                        <input type="url" 
                               class="w-full px-4 py-3 rounded-xl border {{ $errors->has('link') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500' }} bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition-colors mb-1" 
                               id="link" 
                               name="link" 
                               value="{{ old('link') }}" 
                               placeholder="https://drive.google.com/karya123">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Link Google Drive, GitHub, atau URL lainnya</p>
                        @error('link')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- 7b. Upload PDF Laporan/Poster --}}
                    <div>
                        <label for="file_karya" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Dokumen Laporan/Poster (PDF) <span class="text-sm font-normal text-gray-500">(Opsional)</span></label>
                        <input type="file" 
                               class="w-full px-4 py-2.5 rounded-xl border {{ $errors->has('file_karya') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500' }} bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition-colors mb-1" 
                               id="file_karya" 
                               name="file_karya" 
                               accept="application/pdf">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Unggah berkas laporan atau poster dalam format PDF (Maks. 10MB)</p>
                        @error('file_karya')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- 8. Upload Gambar --}}
                    <div>
                        <label for="gambar" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Screenshot/Gambar Karya <span class="text-red-500">*</span></label>
                        
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 {{ $errors->has('gambar') ? 'border-red-300' : 'border-gray-300 dark:border-gray-600' }} border-dashed rounded-xl bg-gray-50 dark:bg-gray-700/50 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <div class="space-y-1 text-center">
                                <i class="bi bi-image text-4xl text-gray-400 dark:text-gray-500"></i>
                                <div class="flex text-sm text-gray-600 dark:text-gray-400 justify-center mt-2">
                                    <label for="gambar" class="relative cursor-pointer bg-white dark:bg-gray-800 rounded-md font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 focus-within:outline-none px-2 py-1">
                                        <span>Upload a file</span>
                                        <input id="gambar" name="preview_karya" type="file" class="sr-only" accept="image/*" required>
                                    </label>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG up to 2MB</p>
                            </div>
                        </div>

                        @error('gambar')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Buttons --}}
                    <div class="flex flex-wrap items-center gap-4 pt-6 border-t border-gray-200 dark:border-gray-700 mt-8">
                        <button type="submit" class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-md transition-colors flex items-center">
                            <i class="bi bi-upload mr-2"></i>Unggah Karya
                        </button>
                        <a href="{{ route('home') }}" class="px-8 py-3 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-white font-bold rounded-xl transition-colors flex items-center">
                            <i class="bi bi-x-circle mr-2"></i>Batal
                        </a>
                    </div>
                </form>
                @endif
            </div>
        </div>
    </div>
</main>
@endsection