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
            <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 dark:text-white tracking-tight">Dosen Teknologi Rekayasa Perangkat Lunak Sekolah Vokasi IPB University</h2>
            <div class="w-24 h-1.5 bg-gradient-to-r from-indigo-600 to-indigo-400 rounded-full mx-auto mt-6"></div>
        </div>

        {{-- Live Search Box --}}
        <div class="max-w-md mx-auto mb-12 fade-in-up">
            <div class="relative flex items-center">
                <span class="absolute left-4 text-gray-400 dark:text-gray-500">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" 
                       x-model="searchQuery"
                       class="w-full pl-12 pr-4 py-3.5 rounded-full border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-all text-sm font-medium" 
                       placeholder="Cari dosen berdasarkan nama atau prodi...">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @foreach ($dosens as $dosen)
                <div class="dosen-card bg-white dark:bg-gray-800 rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col items-center p-8 border border-gray-100 dark:border-gray-700 group fade-in-up"
                     x-show="filterDosen('{{ addslashes($dosen->nama) }}', '{{ addslashes($dosen->prodi) }}')">
                    
                    <div class="relative w-32 h-32 mb-6">
                        @if ($dosen->foto)
                            <img src="{{ asset('storage/' . $dosen->foto) }}" 
                                 class="w-full h-full object-cover rounded-full shadow-md group-hover:scale-105 transition-transform duration-300 ring-4 ring-indigo-50 dark:ring-gray-700"
                                 alt="Foto {{ $dosen->nama }}">
                        @else
                            <img src="{{ asset('images/default-user.png') }}"
                                 class="w-full h-full object-cover rounded-full shadow-md group-hover:scale-105 transition-transform duration-300 ring-4 ring-indigo-50 dark:ring-gray-700"
                                 alt="Default Foto">
                        @endif
                    </div>

                    <h5 class="text-xl font-bold text-gray-900 dark:text-white text-center mb-2 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">{{ $dosen->nama }}</h5>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 text-center mb-6">{{ $dosen->prodi }}</p>

                    <span class="mt-auto px-4 py-1.5 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 text-xs font-bold uppercase tracking-wider rounded-full">
                        {{ $dosen->status ?? 'Aktif' }}
                    </span>
                    
                </div>
            @endforeach

            {{-- Dynamic No Results Message --}}
            <div class="col-span-full" id="no-dosen-results" style="display: none;">
                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 text-blue-700 dark:text-blue-400 px-6 py-4 rounded-xl flex items-center justify-center">
                    <i class="bi bi-info-circle mr-3 text-xl"></i>
                    <span class="font-medium">Tidak ada dosen yang cocok dengan pencarian Anda.</span>
                </div>
            </div>
        </div>

    </div>
</main>
@endsection
