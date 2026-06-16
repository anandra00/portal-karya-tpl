@extends('layouts.app')

@section('title', 'Dosen')



@section('hero')
@include('partials.hero', [
    'title' => 'Direktori Dosen',
    'subtitle' => 'Daftar Pengajar & Staf Akademik TRPL Sekolah Vokasi IPB University'
])
@endsection

@section('content')
<main class="py-20 bg-gray-50 dark:bg-gray-900 transition-colors duration-300"
      x-data="{ 
          searchQuery: '',
          filterDosen(nama, prodi) {
              if (!this.searchQuery) return true;
              const q = this.searchQuery.toLowerCase().trim();
              return nama.toLowerCase().includes(q) || prodi.toLowerCase().includes(q);
          },
          checkEmptyGrid() {
              setTimeout(() => {
                  const cards = document.querySelectorAll('.dosen-card');
                  let visibleCount = 0;
                  cards.forEach(card => {
                      if (card.style.display !== 'none') visibleCount++;
                  });
                  const noResults = document.getElementById('no-dosen-results');
                  if (noResults) {
                      noResults.style.display = visibleCount === 0 ? 'block' : 'none';
                  }
              }, 50);
          },
          init() {
              this.$watch('searchQuery', () => this.checkEmptyGrid());
              this.checkEmptyGrid();
          }
      }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-16">
            <span class="inline-flex items-center gap-2 text-xs font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-widest bg-indigo-50 dark:bg-indigo-950/40 px-4 py-1.5 rounded-full border border-indigo-100 dark:border-indigo-900/30 mb-4">
                <i class="bi bi-mortarboard-fill"></i>
                Tenaga Pengajar
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 dark:text-white tracking-tight">Dosen Teknologi Rekayasa Perangkat Lunak<br class="hidden sm:block"/> Sekolah Vokasi IPB University</h2>
            <div class="w-24 h-1.5 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-full mx-auto mt-6"></div>
        </div>

        {{-- Live Search Box --}}
        <div class="max-w-md mx-auto mb-14 fade-in-up">
            <div class="relative flex items-center group">
                <span class="absolute left-5 text-gray-400 dark:text-gray-500 group-focus-within:text-indigo-500 transition-colors">
                    <i class="bi bi-search text-lg"></i>
                </span>
                <input type="text" 
                       x-model="searchQuery"
                       class="w-full pl-14 pr-4 py-4 rounded-2xl border border-gray-200/80 dark:border-gray-700 bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm focus:shadow-[0_0_30px_rgba(99,102,241,0.12)] transition-all text-sm font-medium outline-none" 
                       placeholder="Cari dosen berdasarkan nama atau prodi...">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @foreach ($dosens as $dosen)
                <div class="dosen-card bg-white dark:bg-gray-800 rounded-2xl shadow-sm overflow-hidden flex flex-col items-center p-8 border border-gray-100 dark:border-gray-700 group fade-in-up glow-ring"
                     x-show="filterDosen('{{ addslashes($dosen->nama) }}', '{{ addslashes($dosen->prodi) }}')">
                    
                    {{-- Gradient ring photo --}}
                    <div class="relative w-32 h-32 mb-6" x-data="{ loaded: false }" x-init="if ($refs.img && $refs.img.complete) loaded = true">
                        {{-- Animated gradient ring --}}
                        <div class="absolute -inset-1.5 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 rounded-full opacity-0 group-hover:opacity-70 transition-opacity duration-500 blur-sm animate-spin-slow"></div>
                        <div class="absolute -inset-1 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        
                        <div class="relative w-full h-full rounded-full overflow-hidden bg-gray-200 dark:bg-gray-700 ring-3 ring-white dark:ring-gray-800" :class="loaded ? '' : 'animate-pulse'">
                            @if ($dosen->foto)
                                <img x-ref="img" src="{{ asset('storage/' . $dosen->foto) }}" 
                                     class="w-full h-full object-cover transition-all duration-500 group-hover:scale-110"
                                     loading="lazy"
                                     @load="loaded = true"
                                     :class="loaded ? 'opacity-100' : 'opacity-0'"
                                     alt="Foto {{ $dosen->nama }}">
                            @else
                                <img src="{{ asset('images/default-user.png') }}"
                                     class="w-full h-full object-cover transition-all duration-300 group-hover:scale-105"
                                     x-init="loaded = true"
                                     alt="Default Foto">
                            @endif
                        </div>
                    </div>

                    <h5 class="text-lg font-bold text-gray-900 dark:text-white text-center mb-1 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">{{ $dosen->nama }}</h5>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 text-center mb-5">{{ $dosen->prodi }}</p>

                    @if($dosen->research_interest)
                        <div class="flex flex-wrap gap-1.5 justify-center mb-6 max-w-[220px]">
                            @foreach(explode(',', $dosen->research_interest) as $interest)
                                <span class="px-2.5 py-0.5 text-[10px] font-bold bg-indigo-50 dark:bg-indigo-950/40 text-indigo-600 dark:text-indigo-400 rounded-full border border-indigo-100 dark:border-indigo-900/30 whitespace-nowrap transition-colors group-hover:bg-indigo-100 dark:group-hover:bg-indigo-900/60">
                                    {{ trim($interest) }}
                                </span>
                            @endforeach
                        </div>
                    @endif

                    <span class="mt-auto inline-flex items-center gap-1.5 px-4 py-1.5 bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 text-xs font-bold uppercase tracking-wider rounded-full border border-emerald-100 dark:border-emerald-800/50">
                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span>
                        {{ $dosen->status ?? 'Aktif' }}
                    </span>
                    
                </div>
            @endforeach

            {{-- Dynamic No Results Message --}}
            <div class="col-span-full" id="no-dosen-results" style="display: none;">
                <div class="text-center py-16 bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700">
                    <i class="bi bi-person-x text-5xl text-gray-300 dark:text-gray-600 mb-4 block"></i>
                    <h3 class="text-lg font-bold text-gray-700 dark:text-gray-300">Tidak ada dosen ditemukan</h3>
                    <p class="text-gray-500 dark:text-gray-400 mt-2">Coba gunakan kata kunci pencarian yang lain.</p>
                </div>
            </div>
        </div>

    </div>
</main>
@endsection
