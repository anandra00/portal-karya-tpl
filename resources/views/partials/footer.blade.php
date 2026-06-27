{{-- Premium Footer with Wave Separator --}}
<footer id="kontak" class="wave-separator bg-[#1E1B4B] dark:bg-gray-950 text-white pt-16 pb-8 mt-auto relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row items-center lg:items-start lg:justify-between gap-12">
            
            <!-- Logo Section -->
            <div class="w-full lg:w-1/4 flex flex-col items-center lg:items-start gap-4">
                <a href="{{ route('home') }}" class="block group"> 
                    <img src="{{ asset('images/logosv.png') }}" alt="Logo SV IPB" class="h-28 object-contain group-hover:scale-105 transition-transform duration-300">
                </a>
                <p class="text-indigo-300/70 text-sm text-center lg:text-left leading-relaxed max-w-xs">
                    Portal Karya Digital untuk menampilkan kreativitas dan inovasi mahasiswa TRPL.
                </p>
            </div>
            
            <!-- Content Section -->
            <div class="w-full lg:w-3/4 grid grid-cols-1 md:grid-cols-3 gap-8 text-center md:text-left">
                
                <!-- Alamat -->
                <div>
                    <h5 class="font-bold text-lg mb-5 text-white flex items-center justify-center md:justify-start gap-2">
                        <i class="bi bi-geo-alt-fill text-indigo-400"></i>
                        Alamat
                    </h5>
                    <div class="text-indigo-200/70 space-y-4 text-sm leading-relaxed">
                        <div class="group">
                            <strong class="text-white/90 block mb-1 group-hover:text-indigo-300 transition-colors">Kampus Bogor</strong>
                            Jl. Raya Pajajaran, Kota Bogor, Jawa Barat 16128
                        </div>
                        <div class="group">
                            <strong class="text-white/90 block mb-1 group-hover:text-indigo-300 transition-colors">Kampus Sukabumi</strong>
                            Jl. Sarasa No. 45, Babakan, Kec. Cibeureum, Kota Sukabumi, Jawa Barat 43142
                        </div>
                    </div>
                </div>

                <!-- Kontak -->
                <div>
                    <h5 class="font-bold text-lg mb-5 text-white flex items-center justify-center md:justify-start gap-2">
                        <i class="bi bi-chat-dots-fill text-indigo-400"></i>
                        Kontak
                    </h5>
                    <ul class="space-y-3 text-sm">
                        <li>
                            <a href="tel:(0251)8348007" class="text-indigo-200/70 hover:text-white transition-colors flex items-center justify-center md:justify-start group gap-3">
                                <span class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center group-hover:bg-indigo-600/30 transition-all">
                                    <i class="bi bi-telephone-fill text-indigo-400 text-sm group-hover:text-indigo-300"></i>
                                </span>
                                (0251) 8348007
                            </a>
                        </li>
                        <li>
                            <a href="mailto:sv@apps.ipb.ac.id" class="text-indigo-200/70 hover:text-white transition-colors flex items-center justify-center md:justify-start group gap-3">
                                <span class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center group-hover:bg-indigo-600/30 transition-all">
                                    <i class="bi bi-envelope-fill text-indigo-400 text-sm group-hover:text-indigo-300"></i>
                                </span>
                                sv@apps.ipb.ac.id
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Sosial Media -->
                <div>
                    <h5 class="font-bold text-lg mb-5 text-white flex items-center justify-center md:justify-start gap-2">
                        <i class="bi bi-share-fill text-indigo-400"></i>
                        Sosial Media
                    </h5>
                    <ul class="space-y-3 text-sm">
                        <li>
                            <a href="https://www.instagram.com/tpl.svipb" target="_blank" class="text-indigo-200/70 hover:text-white transition-all flex items-center justify-center md:justify-start group gap-3">
                                <span class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center group-hover:bg-gradient-to-br group-hover:from-purple-600/30 group-hover:to-pink-600/30 transition-all group-hover:scale-110">
                                    <i class="bi bi-instagram text-indigo-400 text-sm group-hover:text-pink-400"></i>
                                </span>
                                tpl.svipb
                            </a>
                        </li>
                        <li>
                            <a href="https://www.tiktok.com/@tpl.svipb" target="_blank" class="text-indigo-200/70 hover:text-white transition-all flex items-center justify-center md:justify-start group gap-3">
                                <span class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center group-hover:bg-white/10 transition-all group-hover:scale-110">
                                    <i class="bi bi-tiktok text-indigo-400 text-sm group-hover:text-white"></i>
                                </span>
                                tpl.svipb
                            </a>
                        </li>
                    </ul>
                </div>

            </div>
        </div>

        {{-- Decorative line --}}
        <div class="mt-14 mb-8 flex items-center gap-4">
            <div class="flex-1 h-px bg-gradient-to-r from-transparent via-indigo-700/50 to-transparent"></div>
            <div class="flex gap-1.5">
                <span class="w-1.5 h-1.5 rounded-full bg-indigo-500/50"></span>
                <span class="w-1.5 h-1.5 rounded-full bg-indigo-400/50"></span>
                <span class="w-1.5 h-1.5 rounded-full bg-indigo-500/50"></span>
            </div>
            <div class="flex-1 h-px bg-gradient-to-r from-transparent via-indigo-700/50 to-transparent"></div>
        </div>

        <div class="text-center">
            <p class="text-indigo-300/50 text-sm font-medium">
                &copy; {{ date('Y') }} Information and Communications Technology – IPB University. All Rights Reserved.
            </p>
        </div>
    </div>
</footer>