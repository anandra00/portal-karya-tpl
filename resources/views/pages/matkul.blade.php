@extends('layouts.app')

@section('title', 'Mata Kuliah - Portal TPL SVIPB')



@section('hero')
@include('partials.hero', [
    'title' => 'Kurikulum & Mata Kuliah',
    'subtitle' => 'Struktur Kurikulum Program Studi TRPL Sekolah Vokasi IPB University'
])
@endsection

@section('content')
<main class="py-20 bg-gray-50 dark:bg-gray-900 transition-colors duration-300" x-data="{ activeSem: 1 }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-16">
            <span class="inline-flex items-center gap-2 text-xs font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-widest bg-indigo-50 dark:bg-indigo-950/40 px-4 py-1.5 rounded-full border border-indigo-100 dark:border-indigo-900/30 mb-4">
                <i class="bi bi-journal-bookmark-fill"></i>
                Kurikulum
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 dark:text-white tracking-tight">Mata Kuliah Teknologi Rekayasa Perangkat Lunak<br class="hidden sm:block"/> Sekolah Vokasi IPB University</h2>
            <div class="w-24 h-1.5 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-full mx-auto mt-6"></div>
        </div>

        {{-- Fokus Kurikulum --}}
        <div class="mb-16 fade-in-up">
            <div class="bg-gradient-to-br from-indigo-50 to-blue-50 dark:from-gray-800 dark:to-gray-800 rounded-3xl p-8 sm:p-12 shadow-sm border border-indigo-100 dark:border-gray-700 relative overflow-hidden">
                <div class="absolute -right-16 -top-16 w-48 h-48 bg-gradient-to-br from-indigo-200/30 to-purple-200/30 dark:from-indigo-900/10 dark:to-purple-900/10 rounded-full blur-2xl"></div>
                
                <div class="relative z-10">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-indigo-100 dark:bg-indigo-900/40 rounded-xl flex items-center justify-center text-indigo-600 dark:text-indigo-400">
                            <i class="bi bi-lightbulb-fill text-xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-indigo-900 dark:text-white">Fokus Kurikulum Berbasis Proyek</h3>
                    </div>
                    <p class="text-lg text-gray-700 dark:text-gray-300 mb-8 leading-relaxed">
                        Kurikulum Program Studi Sarjana Terapan (D4) TRPL dirancang untuk menghasilkan talenta digital yang siap terjun ke industri. Menggunakan pendekatan <strong>Project-Based Learning</strong>, mahasiswa tidak hanya belajar teori, tetapi langsung memecahkan masalah riil di bidang pertanian, kelautan, dan biosains tropika.
                    </p>
                    
                    <h5 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                        <i class="bi bi-stack text-indigo-500"></i>
                        Mata Kuliah Inti (Core Subjects):
                    </h5>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @php
                            $coreSubjects = [
                                'Rekayasa Perangkat Lunak', 'Pengembangan Web & Mobile App',
                                'Manajemen Basis Data & Big Data', 'Jaringan Komputer & Keamanan Siber',
                                'Berpikir Komputasional & Algoritma', 'Techno-Socio-Entrepreneurship'
                            ];
                        @endphp
                        @foreach ($coreSubjects as $subject)
                        <div class="flex items-center gap-3 p-3 bg-white/60 dark:bg-gray-700/30 rounded-xl border border-white/80 dark:border-gray-600/30 hover:bg-white dark:hover:bg-gray-700/50 transition-all">
                            <div class="w-8 h-8 rounded-lg bg-indigo-100 dark:bg-indigo-900/40 flex items-center justify-center text-indigo-500 flex-shrink-0">
                                <i class="bi bi-check-lg text-sm font-bold"></i>
                            </div>
                            <span class="text-gray-700 dark:text-gray-300 font-medium">{{ $subject }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Semester Tab Navigation --}}
        <div class="mb-8 fade-in-up">
            <div class="flex overflow-x-auto gap-2 pb-2 scrollbar-hide justify-center flex-wrap">
                @for ($s = 1; $s <= 8; $s++)
                <button @click="activeSem = {{ $s }}"
                        :class="activeSem === {{ $s }} ? 'bg-gradient-to-r from-indigo-600 to-indigo-700 text-white shadow-lg shadow-indigo-600/20' : 'bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-400 border border-gray-200 dark:border-gray-700 hover:border-indigo-400 hover:text-indigo-600 dark:hover:text-indigo-400'"
                        class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all duration-200 whitespace-nowrap transform hover:scale-105 active:scale-95 shadow-sm">
                    Semester {{ $s }}
                </button>
                @endfor
            </div>
        </div>

        @php
            $semesters = [
                1 => $semester1, 2 => $semester2, 3 => $semester3, 4 => $semester4,
                5 => $semester5, 6 => $semester6, 7 => $semester7, 8 => $semester8,
            ];
        @endphp

        {{-- Semester Tables --}}
        @foreach(range(1, 8) as $sem)
        <div x-show="activeSem === {{ $sem }}" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="fade-in-up">
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden glow-ring">
                <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 dark:from-indigo-800 dark:to-indigo-900 px-8 py-5 flex items-center justify-between">
                    <h3 class="text-xl font-bold text-white flex items-center gap-3">
                        <span class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center text-sm">{{ $sem }}</span>
                        Semester {{ $sem }}
                    </h3>
                    <span class="text-indigo-200 text-sm font-medium">{{ count($semesters[$sem]) }} Mata Kuliah</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-700/50 text-gray-600 dark:text-gray-300 text-xs uppercase tracking-wider border-b border-gray-200 dark:border-gray-700">
                                <th class="px-6 py-4 font-bold">Kode</th>
                                <th class="px-6 py-4 font-bold">Mata Kuliah</th>
                                <th class="px-6 py-4 font-bold text-center whitespace-nowrap">SKS (T-P)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700/50">
                            @forelse($semesters[$sem] as $mk)
                            <tr class="hover:bg-indigo-50/50 dark:hover:bg-indigo-950/20 transition-colors group">
                                <td class="px-6 py-4 text-gray-900 dark:text-gray-300 font-mono text-sm font-bold whitespace-nowrap group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">{{ $mk->kode_matkul }}</td>
                                <td class="px-6 py-4 text-gray-700 dark:text-gray-400 font-medium">
                                    {{ $mk->nama_matkul }}
                                    @if(in_array($mk->kode_matkul, ['SV1002', 'SV1003', 'SV1004', 'SV1005', 'SV1006', 'SV1106']))
                                        <span class="ml-2 px-2.5 py-0.5 bg-amber-50 dark:bg-amber-950/40 text-amber-600 dark:text-amber-400 text-xs font-bold rounded-full border border-amber-100 dark:border-amber-900/30">Pilih Salah Satu</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center font-medium whitespace-nowrap">
                                    @php
                                        $total = $mk->sks_teori + $mk->sks_praktik;
                                        $praktikRatio = $total > 0 ? ($mk->sks_praktik / $total) * 100 : 0;
                                    @endphp
                                    <div class="flex items-center justify-center gap-2">
                                        <span class="text-gray-900 dark:text-gray-300 font-bold">{{ $total }}</span>
                                        <span class="text-xs text-gray-400">({{ $mk->sks_teori }}-{{ $mk->sks_praktik }})</span>
                                        {{-- Color-coded indicator --}}
                                        @if($praktikRatio >= 60)
                                            <span class="w-2 h-2 rounded-full bg-emerald-500" title="Praktik dominan"></span>
                                        @elseif($praktikRatio >= 40)
                                            <span class="w-2 h-2 rounded-full bg-amber-500" title="Seimbang"></span>
                                        @else
                                            <span class="w-2 h-2 rounded-full bg-blue-500" title="Teori dominan"></span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400 italic">Belum ada data mata kuliah</td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot class="bg-gray-50 dark:bg-gray-800 border-t-2 border-gray-200 dark:border-gray-700">
                            <tr>
                                <td class="px-6 py-4 font-bold text-gray-900 dark:text-white" colspan="2">Total SKS</td>
                                <td class="px-6 py-4 font-bold text-indigo-600 dark:text-indigo-400 text-center whitespace-nowrap">
                                    @php
                                        $totalSks = 0; $totalTeori = 0; $totalPraktik = 0; $hasReligion = false;
                                        foreach($semesters[$sem] as $mk) {
                                            $isReligion = in_array($mk->kode_matkul, ['SV1002', 'SV1003', 'SV1004', 'SV1005', 'SV1006', 'SV1106']);
                                            if ($isReligion) { if (!$hasReligion) { $totalSks += (int)$mk->sks_teori + (int)$mk->sks_praktik; $totalTeori += (int)$mk->sks_teori; $totalPraktik += (int)$mk->sks_praktik; $hasReligion = true; } }
                                            else { $totalSks += (int)$mk->sks_teori + (int)$mk->sks_praktik; $totalTeori += (int)$mk->sks_teori; $totalPraktik += (int)$mk->sks_praktik; }
                                        }
                                    @endphp
                                    {{ $totalSks }} ({{ $totalTeori }}-{{ $totalPraktik }})
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            {{-- Legend --}}
            <div class="mt-4 flex flex-wrap gap-4 justify-center text-xs text-gray-500 dark:text-gray-400">
                <span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-blue-500"></span> Teori dominan</span>
                <span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-amber-500"></span> Seimbang</span>
                <span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-emerald-500"></span> Praktik dominan</span>
            </div>
        </div>
        @endforeach

    </div>
</main>
@endsection