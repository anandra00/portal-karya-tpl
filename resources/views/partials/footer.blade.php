<footer id="kontak" class="bg-[#1E1B4B] dark:bg-gray-950 text-white pt-12 pb-8 border-t border-indigo-800 dark:border-gray-900 mt-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row items-center lg:items-start lg:justify-between gap-12">
            
            <!-- Logo Section -->
            <div class="w-full lg:w-1/4 flex justify-center lg:justify-start">
                <a href="{{ route('home') }}" class="block"> 
                    <img src="{{ asset('images/logosv.png') }}" alt="Logo SV IPB" class="h-32 object-contain hover:opacity-90 transition-opacity">
                </a>
            </div>
            
            <!-- Content Section -->
            <div class="w-full lg:w-3/4 grid grid-cols-1 md:grid-cols-3 gap-8 text-center md:text-left">
                
                <!-- Alamat -->
                <div>
                    <h5 class="font-bold text-lg mb-4 text-indigo-300">Alamat</h5>
                    <div class="text-indigo-100 dark:text-gray-400 space-y-3 text-sm leading-relaxed">
                        <p>
                            <strong class="text-white block mb-1">Kampus Bogor</strong>
                            Jl. Raya Pajajaran, Kota Bogor, Jawa Barat 16128
                        </p>
                        <p>
                            <strong class="text-white block mb-1">Kampus Sukabumi</strong>
                            Jl. Sarasa No. 45, Babakan, Kec. Cibeureum, Kota Sukabumi, Jawa Barat 43142
                        </p>
                    </div>
                </div>

                <!-- Kontak -->
                <div>
                    <h5 class="font-bold text-lg mb-4 text-indigo-300">Kontak</h5>
                    <ul class="space-y-3 text-sm">
                        <li>
                            <a href="tel:(0251)8348007" class="text-indigo-100 dark:text-gray-400 hover:text-white transition-colors flex items-center justify-center md:justify-start group">
                                <i class="bi bi-telephone-fill mr-3 text-indigo-400 group-hover:text-indigo-300"></i>
                                (0251) 8348007
                            </a>
                        </li>
                        <li>
                            <a href="mailto:sv@apps.ipb.ac.id" class="text-indigo-100 dark:text-gray-400 hover:text-white transition-colors flex items-center justify-center md:justify-start group">
                                <i class="bi bi-envelope-fill mr-3 text-indigo-400 group-hover:text-indigo-300"></i>
                                sv@apps.ipb.ac.id
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Sosial Media -->
                <div>
                    <h5 class="font-bold text-lg mb-4 text-indigo-300">Sosial Media</h5>
                    <ul class="space-y-3 text-sm">
                        <li>
                            <a href="https://www.instagram.com/tpl.svipb" target="_blank" class="text-indigo-100 dark:text-gray-400 hover:text-white transition-colors flex items-center justify-center md:justify-start group">
                                <i class="bi bi-instagram mr-3 text-indigo-400 group-hover:text-pink-500"></i>
                                tpl.svipb
                            </a>
                        </li>
                        <li>
                            <a href="https://www.tiktok.com/@tpl.svipb" target="_blank" class="text-indigo-100 dark:text-gray-400 hover:text-white transition-colors flex items-center justify-center md:justify-start group">
                                <i class="bi bi-tiktok mr-3 text-indigo-400 group-hover:text-white"></i>
                                tpl.svipb
                            </a>
                        </li>
                    </ul>
                </div>

            </div>
        </div>

        <div class="mt-12 pt-8 border-t border-indigo-800 dark:border-gray-800 text-center">
            <p class="text-indigo-200 dark:text-gray-500 text-sm">
                &copy; {{ date('Y') }} Information and Communications Technology – IPB University. All Rights Reserved.
            </p>
        </div>
    </div>
</footer>