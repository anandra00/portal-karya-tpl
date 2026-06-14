@extends('layouts.app')

@section('title', 'FAQ')



@section('hero')
@include('partials.hero')
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
        
        <div class="text-center mb-12">
            <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 dark:text-white tracking-tight">Frequently Asked Questions (FAQ)</h2>
            <div class="w-24 h-1.5 bg-gradient-to-r from-indigo-600 to-indigo-400 rounded-full mx-auto mt-6"></div>
        </div>

        <!-- Search Bar -->
        <div class="mb-10 max-w-md mx-auto">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <i class="bi bi-search text-gray-400 dark:text-gray-500"></i>
                </div>
                <input 
                    type="text" 
                    x-model="search" 
                    placeholder="Cari pertanyaan atau jawaban..." 
                    class="block w-full pl-10 pr-10 py-3.5 border border-gray-200 dark:border-gray-700 rounded-2xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-all duration-200"
                    id="faq-search-input"
                >
                <div class="absolute inset-y-0 right-0 pr-4 flex items-center">
                    <button 
                        type="button" 
                        x-show="search.length > 0" 
                        @click="search = ''" 
                        class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 focus:outline-none"
                        x-cloak
                    >
                        <i class="bi bi-x-circle-fill"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- FAQ Items -->
        <div class="space-y-4 fade-in-up" x-show="hasMatches()">
            
            <div class="faq-item bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden transition-all duration-300"
                 x-show="search.trim() === '' || $el.textContent.toLowerCase().includes(search.toLowerCase())"
                 x-transition>
                <button type="button" class="w-full px-6 py-5 text-left flex justify-between items-center focus:outline-none" @click="selected !== 1 ? selected = 1 : selected = null">
                    <span class="font-bold text-lg text-gray-900 dark:text-white">Apa itu Program Studi Teknologi Rekayasa Perangkat Lunak (TPL)?</span>
                    <i class="bi bi-chevron-down transition-transform duration-300 text-indigo-500" :class="{'rotate-180': selected === 1}"></i>
                </button>
                <div class="px-6 pb-5 text-gray-600 dark:text-gray-300 leading-relaxed" x-show="selected === 1" x-collapse x-cloak>
                    <strong class="text-gray-900 dark:text-white">Jawaban:</strong> TPL adalah program studi vokasi (D4/Sarjana Terapan) di Sekolah Vokasi IPB University yang fokus pada pengembangan perangkat lunak, mulai dari analisis kebutuhan, desain, implementasi, pengujian, hingga pemeliharaan, dengan penekanan pada aplikasi di bidang pertanian, kelautan, dan biosains tropika.
                </div>
            </div>

            <div class="faq-item bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden transition-all duration-300"
                 x-show="search.trim() === '' || $el.textContent.toLowerCase().includes(search.toLowerCase())"
                 x-transition>
                <button type="button" class="w-full px-6 py-5 text-left flex justify-between items-center focus:outline-none" @click="selected !== 2 ? selected = 2 : selected = null">
                    <span class="font-bold text-lg text-gray-900 dark:text-white">Apakah karya mahasiswa di portal ini dapat diunduh?</span>
                    <i class="bi bi-chevron-down transition-transform duration-300 text-indigo-500" :class="{'rotate-180': selected === 2}"></i>
                </button>
                <div class="px-6 pb-5 text-gray-600 dark:text-gray-300 leading-relaxed" x-show="selected === 2" x-collapse x-cloak>
                    <strong class="text-gray-900 dark:text-white">Jawaban:</strong> Kebijakan pengunduhan karya dapat bervariasi tergantung pada jenis karya dan izin dari mahasiswa pembuatnya. Beberapa karya mungkin tersedia untuk diunduh (misalnya laporan atau demo aplikasi), sementara yang lain mungkin hanya bisa dilihat atau diakses melalui tautan eksternal. Silakan periksa detail pada setiap halaman karya.
                </div>
            </div>

            <div class="faq-item bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden transition-all duration-300"
                 x-show="search.trim() === '' || $el.textContent.toLowerCase().includes(search.toLowerCase())"
                 x-transition>
                <button type="button" class="w-full px-6 py-5 text-left flex justify-between items-center focus:outline-none" @click="selected !== 3 ? selected = 3 : selected = null">
                    <span class="font-bold text-lg text-gray-900 dark:text-white">Apa perbedaan TPL dengan program studi Informatika?</span>
                    <i class="bi bi-chevron-down transition-transform duration-300 text-indigo-500" :class="{'rotate-180': selected === 3}"></i>
                </button>
                <div class="px-6 pb-5 text-gray-600 dark:text-gray-300 leading-relaxed" x-show="selected === 3" x-collapse x-cloak>
                    <strong class="text-gray-900 dark:text-white">Jawaban:</strong> TPL (Sarjana Terapan/D4) lebih menekankan pada aspek praktis dan penerapan langsung teknologi rekayasa perangkat lunak untuk menghasilkan solusi siap pakai. Program studi Informatika (Sarjana/S1) seringkali lebih fokus pada aspek teoritis, fundamental ilmu komputer, dan penelitian yang lebih mendalam. Keduanya saling melengkapi di dunia industri.
                </div>
            </div>

            <div class="faq-item bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden transition-all duration-300"
                 x-show="search.trim() === '' || $el.textContent.toLowerCase().includes(search.toLowerCase())"
                 x-transition>
                <button type="button" class="w-full px-6 py-5 text-left flex justify-between items-center focus:outline-none" @click="selected !== 4 ? selected = 4 : selected = null">
                    <span class="font-bold text-lg text-gray-900 dark:text-white">Apakah mahasiswa bisa langsung mengunggah karyanya ke portal?</span>
                    <i class="bi bi-chevron-down transition-transform duration-300 text-indigo-500" :class="{'rotate-180': selected === 4}"></i>
                </button>
                <div class="px-6 pb-5 text-gray-600 dark:text-gray-300 leading-relaxed" x-show="selected === 4" x-collapse x-cloak>
                    <strong class="text-gray-900 dark:text-white">Jawaban:</strong> Umumnya, proses pengunggahan karya melibatkan verifikasi atau kurasi oleh pihak pengelola portal atau dosen pembimbing untuk memastikan kualitas dan kelayakan konten. Mahasiswa mungkin perlu mengirimkan karyanya melalui prosedur tertentu yang ditetapkan oleh program studi. Informasi lebih lanjut dapat ditanyakan kepada koordinator portal atau dosen terkait.
                </div>
            </div>

        </div>

        <!-- No Results Message -->
        <div class="text-center py-16 bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 fade-in-up" 
             x-show="!hasMatches()" 
             x-cloak
             x-transition>
            <i class="bi bi-question-circle text-5xl text-indigo-500 dark:text-indigo-400 mb-4 block"></i>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white">Tidak ada hasil ditemukan</h3>
            <p class="text-gray-500 dark:text-gray-400 mt-2">Coba gunakan kata kunci pencarian yang lain.</p>
        </div>

    </div>
</main>
@endsection