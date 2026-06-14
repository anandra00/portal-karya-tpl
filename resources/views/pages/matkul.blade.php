@extends('layouts.app')

@section('title', 'Mata Kuliah - Portal TPL SVIPB')



@section('hero')
@include('partials.hero', [
    'title' => 'Kurikulum & Mata Kuliah',
    'subtitle' => 'Struktur Kurikulum Program Studi TRPL Sekolah Vokasi IPB University'
])
@endsection

@section('content')
<main class="py-20 bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-16">
            <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 dark:text-white tracking-tight">Mata Kuliah Teknologi Rekayasa Perangkat Lunak Sekolah Vokasi IPB University</h2>
            <div class="w-24 h-1.5 bg-gradient-to-r from-indigo-600 to-indigo-400 rounded-full mx-auto mt-6"></div>
        </div>

        {{-- Fokus Kurikulum --}}
        <div class="mb-16 fade-in-up">
            <div class="bg-gradient-to-br from-indigo-50 to-blue-50 dark:from-gray-800 dark:to-gray-800 rounded-3xl p-8 sm:p-12 shadow-sm border border-indigo-100 dark:border-gray-700">
                <h3 class="text-2xl font-bold text-indigo-900 dark:text-white mb-4">Fokus Kurikulum Berbasis Proyek</h3>
                <p class="text-lg text-gray-700 dark:text-gray-300 mb-8 leading-relaxed">
                    Kurikulum Program Studi Sarjana Terapan (D4) TRPL dirancang untuk menghasilkan talenta digital yang siap terjun ke industri. Menggunakan pendekatan <strong>Project-Based Learning</strong>, mahasiswa tidak hanya belajar teori, tetapi langsung memecahkan masalah riil di bidang pertanian, kelautan, dan biosains tropika.
                </p>
                
                <h5 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Mata Kuliah Inti (Core Subjects):</h5>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <ul class="space-y-4 text-gray-700 dark:text-gray-300 font-medium">
                            <li class="flex items-center"><i class="bi bi-check-circle-fill text-indigo-500 mr-3 text-xl"></i>Rekayasa Perangkat Lunak</li>
                            <li class="flex items-center"><i class="bi bi-check-circle-fill text-indigo-500 mr-3 text-xl"></i>Pengembangan Web & Mobile App</li>
                            <li class="flex items-center"><i class="bi bi-check-circle-fill text-indigo-500 mr-3 text-xl"></i>Manajemen Basis Data & Big Data</li>
                        </ul>
                    </div>
                    <div>
                        <ul class="space-y-4 text-gray-700 dark:text-gray-300 font-medium">
                            <li class="flex items-center"><i class="bi bi-check-circle-fill text-indigo-500 mr-3 text-xl"></i>Jaringan Komputer & Keamanan Siber</li>
                            <li class="flex items-center"><i class="bi bi-check-circle-fill text-indigo-500 mr-3 text-xl"></i>Berpikir Komputasional & Algoritma</li>
                            <li class="flex items-center"><i class="bi bi-check-circle-fill text-indigo-500 mr-3 text-xl"></i>Techno-Socio-Entrepreneurship</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        @php
            $semesters = [
                1 => $semester1, 2 => $semester2, 3 => $semester3, 4 => $semester4,
                5 => $semester5, 6 => $semester6, 7 => $semester7, 8 => $semester8,
            ];
        @endphp

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            @foreach(range(1, 8) as $sem)
            <div class="fade-in-up">
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden h-full flex flex-col">
                    <div class="bg-indigo-600 dark:bg-indigo-900 px-6 py-4">
                        <h3 class="text-xl font-bold text-white mb-0">Semester {{ $sem }}</h3>
                    </div>
                    <div class="overflow-x-auto flex-grow">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 dark:bg-gray-700/50 text-gray-700 dark:text-gray-300 text-sm uppercase tracking-wider border-b border-gray-200 dark:border-gray-700">
                                    <th class="px-6 py-4 font-semibold">Kode</th>
                                    <th class="px-6 py-4 font-semibold">Mata Kuliah</th>
                                    <th class="px-6 py-4 font-semibold text-center whitespace-nowrap">SKS (T-P)</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700/50">
                                @forelse($semesters[$sem] as $mk)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                                    <td class="px-6 py-4 text-gray-900 dark:text-gray-300 font-medium whitespace-nowrap">{{ $mk->kode_matkul }}</td>
                                    <td class="px-6 py-4 text-gray-700 dark:text-gray-400">
                                        {{ $mk->nama_matkul }}
                                        @if(in_array($mk->kode_matkul, ['SV1002', 'SV1003', 'SV1004', 'SV1005', 'SV1006', 'SV1106']))
                                            <span class="ml-2 px-2.5 py-0.5 bg-indigo-50 dark:bg-indigo-950/40 text-indigo-600 dark:text-indigo-400 text-xs font-bold rounded-full border border-indigo-100 dark:border-indigo-900/30">Pilih Salah Satu</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-gray-900 dark:text-gray-300 text-center font-medium whitespace-nowrap">{{ $mk->sks_teori + $mk->sks_praktik }} ({{ $mk->sks_teori }}-{{ $mk->sks_praktik }})</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400 italic">Belum ada data mata kuliah</td>
                                </tr>
                                @endforelse
                            </tbody>
                            <tfoot class="bg-gray-50 dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
                                <tr>
                                    <td class="px-6 py-4 font-bold text-gray-900 dark:text-white" colspan="2">Total SKS</td>
                                    <td class="px-6 py-4 font-bold text-indigo-600 dark:text-indigo-400 text-center whitespace-nowrap">
                                        @php
                                            $totalSks = 0;
                                            $totalTeori = 0;
                                            $totalPraktik = 0;
                                            $hasReligion = false;
                                            
                                            foreach($semesters[$sem] as $mk) {
                                                $isReligion = in_array($mk->kode_matkul, ['SV1002', 'SV1003', 'SV1004', 'SV1005', 'SV1006', 'SV1106']);
                                                if ($isReligion) {
                                                    if (!$hasReligion) {
                                                        $totalSks += (int)$mk->sks_teori + (int)$mk->sks_praktik;
                                                        $totalTeori += (int)$mk->sks_teori;
                                                        $totalPraktik += (int)$mk->sks_praktik;
                                                        $hasReligion = true;
                                                    }
                                                } else {
                                                    $totalSks += (int)$mk->sks_teori + (int)$mk->sks_praktik;
                                                    $totalTeori += (int)$mk->sks_teori;
                                                    $totalPraktik += (int)$mk->sks_praktik;
                                                }
                                            }
                                        @endphp
                                        {{ $totalSks }} ({{ $totalTeori }}-{{ $totalPraktik }})
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</main>
@endsection