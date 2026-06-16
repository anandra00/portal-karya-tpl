@extends('layouts.app')

@section('title', 'FAQ')



@section('hero')
@include('partials.hero', [
    'title' => 'Pertanyaan Umum (FAQ)',
    'subtitle' => 'Temukan Jawaban atas Pertanyaan Anda Seputar Program Studi TRPL'
])
@endsection

@section('content')
<main class="py-20 bg-gray-50 dark:bg-gray-900 transition-colors duration-300"
      x-data="{ 
          selected: null, 
          search: '',
          hasMatches() {
              if (this.search.trim() === '') return true;
              let query = this.search.toLowerCase();
              let items = document.querySelectorAll('.faq-item');
              for (let item of items) {
                  if (item.textContent.toLowerCase().includes(query)) {
                      return true;
                  }
              }
              return false;
          }
      }">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-14">
            <span class="inline-flex items-center gap-2 text-xs font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-widest bg-indigo-50 dark:bg-indigo-950/40 px-4 py-1.5 rounded-full border border-indigo-100 dark:border-indigo-900/30 mb-4">
                <i class="bi bi-question-circle"></i>
                Bantuan
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 dark:text-white tracking-tight">Frequently Asked Questions</h2>
            <div class="w-24 h-1.5 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-full mx-auto mt-6"></div>
        </div>

        <!-- Search Bar -->
        <div class="mb-12 max-w-lg mx-auto fade-in-up">
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                    <i class="bi bi-search text-gray-400 dark:text-gray-500 group-focus-within:text-indigo-500 transition-colors text-lg"></i>
                </div>
                <input 
                    type="text" 
                    x-model="search" 
                    placeholder="Cari pertanyaan atau jawaban..." 
                    class="block w-full pl-14 pr-12 py-4 border border-gray-200/80 dark:border-gray-700 rounded-2xl bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm focus:shadow-[0_0_30px_rgba(99,102,241,0.12)] transition-all duration-200 font-medium"
                    id="faq-search-input"
                >
                <div class="absolute inset-y-0 right-0 pr-4 flex items-center">
                    <button 
                        type="button" 
                        x-show="search.length > 0" 
                        @click="search = ''" 
                        class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 focus:outline-none transition-colors"
                        x-cloak
                    >
                        <i class="bi bi-x-circle-fill"></i>
                    </button>
                </div>
            </div>
        </div>

        @php
            $faqs = [
                ['q' => 'Apa itu Program Studi Teknologi Rekayasa Perangkat Lunak (TPL)?', 'a' => 'TPL adalah program studi vokasi (D4/Sarjana Terapan) di Sekolah Vokasi IPB University yang fokus pada pengembangan perangkat lunak, mulai dari analisis kebutuhan, desain, implementasi, pengujian, hingga pemeliharaan, dengan penekanan pada aplikasi di bidang pertanian, kelautan, dan biosains tropika.'],
                ['q' => 'Apakah karya mahasiswa di portal ini dapat diunduh?', 'a' => 'Kebijakan pengunduhan karya dapat bervariasi tergantung pada jenis karya dan izin dari mahasiswa pembuatnya. Beberapa karya mungkin tersedia untuk diunduh (misalnya laporan atau demo aplikasi), sementara yang lain mungkin hanya bisa dilihat atau diakses melalui tautan eksternal. Silakan periksa detail pada setiap halaman karya.'],
                ['q' => 'Apa perbedaan TPL dengan program studi Informatika?', 'a' => 'TPL (Sarjana Terapan/D4) lebih menekankan pada aspek praktis dan penerapan langsung teknologi rekayasa perangkat lunak untuk menghasilkan solusi siap pakai. Program studi Informatika (Sarjana/S1) seringkali lebih fokus pada aspek teoritis, fundamental ilmu komputer, dan penelitian yang lebih mendalam. Keduanya saling melengkapi di dunia industri.'],
                ['q' => 'Apakah mahasiswa bisa langsung mengunggah karyanya ke portal?', 'a' => 'Umumnya, proses pengunggahan karya melibatkan verifikasi atau kurasi oleh pihak pengelola portal atau dosen pembimbing untuk memastikan kualitas dan kelayakan konten. Mahasiswa mungkin perlu mengirimkan karyanya melalui prosedur tertentu yang ditetapkan oleh program studi. Informasi lebih lanjut dapat ditanyakan kepada koordinator portal atau dosen terkait.'],
            ];
        @endphp

        <!-- FAQ Items -->
        <div class="space-y-4 fade-in-up" x-show="hasMatches()">
            @foreach ($faqs as $index => $faq)
            <div class="faq-item bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden transition-all duration-300 hover:shadow-md"
                 :class="selected === {{ $index + 1 }} ? 'ring-2 ring-indigo-500/20 border-indigo-200 dark:border-indigo-800' : ''"
                 x-show="search.trim() === '' || $el.textContent.toLowerCase().includes(search.toLowerCase())"
                 x-transition>
                <button type="button" class="w-full px-6 py-5 text-left flex items-center gap-4 focus:outline-none group" @click="selected !== {{ $index + 1 }} ? selected = {{ $index + 1 }} : selected = null">
                    {{-- Number badge --}}
                    <span class="flex-shrink-0 w-8 h-8 rounded-xl flex items-center justify-center text-sm font-bold transition-all duration-300"
                          :class="selected === {{ $index + 1 }} ? 'bg-indigo-600 text-white shadow-md' : 'bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400 group-hover:bg-indigo-100 dark:group-hover:bg-indigo-900/30 group-hover:text-indigo-600 dark:group-hover:text-indigo-400'">
                        {{ $index + 1 }}
                    </span>
                    <span class="flex-grow font-bold text-lg text-gray-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">{{ $faq['q'] }}</span>
                    <i class="bi bi-chevron-down transition-transform duration-300 text-indigo-500 text-lg flex-shrink-0" :class="{'rotate-180': selected === {{ $index + 1 }}}"></i>
                </button>
                <div class="px-6 pb-6 text-gray-600 dark:text-gray-300 leading-relaxed" x-show="selected === {{ $index + 1 }}" x-collapse x-cloak>
                    <div class="pl-12 border-l-2 border-indigo-200 dark:border-indigo-800 ml-0.5">
                        <p>{{ $faq['a'] }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- No Results Message -->
        <div class="text-center py-16 bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 fade-in-up" 
             x-show="!hasMatches()" 
             x-cloak
             x-transition>
            <i class="bi bi-emoji-frown text-5xl text-indigo-300 dark:text-indigo-700 mb-4 block"></i>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white">Tidak ada hasil ditemukan</h3>
            <p class="text-gray-500 dark:text-gray-400 mt-2">Coba gunakan kata kunci pencarian yang lain.</p>
        </div>

    </div>
</main>
@endsection