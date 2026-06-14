<nav x-data="{ mobileMenuOpen: false }" class="fixed w-full z-50 bg-white/80 dark:bg-gray-900/80 backdrop-blur-md shadow-sm transition-all duration-300 border-b border-gray-200 dark:border-gray-800">
    <div class="w-full px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center space-x-3">
                <img src="{{ asset('images/logotpl.png') }}" alt="Logo TPL" class="h-12 w-auto">
                <div class="hidden sm:block leading-tight">
                    <strong class="block text-lg text-indigo-900 dark:text-indigo-100">TPL SV IPB</strong>
                    <small class="block text-sm font-medium text-indigo-600 dark:text-indigo-400">Teknologi Rekayasa Perangkat Lunak</small>
                </div>
            </a>

            <!-- Desktop Menu -->
            <div class="hidden lg:flex lg:items-center lg:space-x-8">
                <a href="{{ route('home') }}" class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 font-semibold transition {{ request()->routeIs('home') ? 'text-indigo-600 dark:text-indigo-400' : '' }}">Beranda</a>
                <a href="{{ route('karya.public') }}" class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 font-semibold transition {{ request()->routeIs('karya.public') || request()->routeIs('karya.public.show') ? 'text-indigo-600 dark:text-indigo-400' : '' }}">Karya</a>
                <a href="{{ route('tentang') }}" class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 font-semibold transition {{ request()->routeIs('tentang') ? 'text-indigo-600 dark:text-indigo-400' : '' }}">Tentang</a>
                <a href="{{ route('homepage.dosen') }}" class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 font-semibold transition {{ request()->routeIs('homepage.dosen') ? 'text-indigo-600 dark:text-indigo-400' : '' }}">Dosen</a>
                <a href="{{ route('matakuliah.user') }}" class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 font-semibold transition {{ request()->routeIs('matakuliah.user') ? 'text-indigo-600 dark:text-indigo-400' : '' }}">Mata Kuliah</a>
                <a href="{{ route('faq') }}" class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 font-semibold transition {{ request()->routeIs('faq') ? 'text-indigo-600 dark:text-indigo-400' : '' }}">FAQ</a>

                <!-- Theme Toggle -->
                <button id="theme-toggle" class="text-gray-500 hover:text-yellow-500 focus:outline-none transition">
                    <i class="bi bi-moon-stars-fill text-lg" id="theme-icon"></i>
                </button>

                <!-- Google Translate Hidden Engine -->
                <div id="google_translate_element"></div>

                <!-- Custom Language Switcher -->
                <div class="relative ml-2 flex items-center">
                    <div class="flex items-center gap-1 bg-indigo-50 dark:bg-indigo-900/30 border border-indigo-200 dark:border-indigo-800 rounded-full px-2 py-1 cursor-pointer hover:bg-indigo-100 dark:hover:bg-indigo-900/50 transition shadow-sm">
                        <i class="bi bi-translate text-indigo-600 dark:text-indigo-400 text-sm pl-1"></i>
                        <select class="custom-language-selector bg-transparent border-none text-xs font-bold text-indigo-700 dark:text-indigo-300 focus:ring-0 cursor-pointer outline-none pl-1 pr-5 appearance-none" style="background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22%234F46E5%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3e%3cpolyline points=%226 9 12 15 18 9%22%3e%3c/polyline%3e%3c/svg%3e'); background-repeat: no-repeat; background-position: right center; background-size: 12px;">
                            <option value="id">ID</option>
                            <option value="en">EN</option>
                        </select>
                    </div>
                </div>

                @auth
                    @if(Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin')
                        <a href="{{ route('dashboard') }}" class="font-bold text-gray-900 dark:text-white flex items-center hover:text-indigo-600 transition">
                            <i class="bi bi-person-circle mr-2"></i>{{ Auth::user()->name }}
                        </a>
                    @else
                        <span class="font-bold text-gray-900 dark:text-white flex items-center">
                            <i class="bi bi-person-circle mr-2"></i>{{ Auth::user()->name }}
                        </span>
                    @endif
                    <a href="{{ route('logout') }}" class="text-red-500 hover:text-red-700 font-semibold transition flex items-center" onclick="event.preventDefault(); document.getElementById('public-logout-form').submit();">
                        <i class="bi bi-box-arrow-right mr-1"></i>Keluar
                    </a>
                    <form id="public-logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @else
                    <a href="{{ route('login') }}" class="px-5 py-2 text-indigo-600 border border-indigo-600 font-semibold rounded-lg hover:bg-indigo-50 transition">Masuk</a>
                    <a href="{{ route('register') }}" class="px-5 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 shadow-md transition">Daftar</a>
                @endauth
            </div>

            <!-- Mobile menu button -->
            <div class="flex lg:hidden items-center space-x-4">
                <button id="theme-toggle-mobile" class="text-gray-500 hover:text-yellow-500 focus:outline-none transition">
                    <i class="bi bi-moon-stars-fill text-lg" id="theme-icon-mobile"></i>
                </button>
                <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="text-gray-500 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white focus:outline-none">
                    <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" style="display: none;"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="mobileMenuOpen" class="lg:hidden bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800 shadow-lg" style="display: none;">
        <div class="px-4 pt-2 pb-6 space-y-2">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-900 dark:text-white hover:bg-gray-50 dark:hover:bg-gray-800">Beranda</a>
            <a href="{{ route('karya.public') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-900 dark:text-white hover:bg-gray-50 dark:hover:bg-gray-800">Karya</a>
            <a href="{{ route('tentang') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-900 dark:text-white hover:bg-gray-50 dark:hover:bg-gray-800">Tentang</a>
            <a href="{{ route('homepage.dosen') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-900 dark:text-white hover:bg-gray-50 dark:hover:bg-gray-800">Dosen</a>
            <a href="{{ route('matakuliah.user') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-900 dark:text-white hover:bg-gray-50 dark:hover:bg-gray-800">Mata Kuliah</a>
            <a href="{{ route('faq') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-900 dark:text-white hover:bg-gray-50 dark:hover:bg-gray-800">FAQ</a>

            <div class="px-3 py-2 flex items-center gap-3">
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Bahasa:</span>
                <div id="google_translate_element_mobile"></div>
                <div class="flex items-center gap-1 bg-indigo-50 dark:bg-indigo-900/30 border border-indigo-200 dark:border-indigo-800 rounded-full px-2 py-1 cursor-pointer">
                    <i class="bi bi-translate text-indigo-600 dark:text-indigo-400 text-sm pl-1"></i>
                    <select class="custom-language-selector bg-transparent border-none text-xs font-bold text-indigo-700 dark:text-indigo-300 focus:ring-0 cursor-pointer outline-none pl-1 pr-5 appearance-none" style="background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22%234F46E5%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3e%3cpolyline points=%226 9 12 15 18 9%22%3e%3c/polyline%3e%3c/svg%3e'); background-repeat: no-repeat; background-position: right center; background-size: 12px;">
                        <option value="id">ID</option>
                        <option value="en">EN</option>
                    </select>
                </div>
            </div>

            <div class="border-t border-gray-200 dark:border-gray-700 pt-4 pb-2">
                @auth
                    @if(Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin')
                        <a href="{{ route('dashboard') }}" class="block px-3 py-2 text-base font-bold text-gray-900 dark:text-white"><i class="bi bi-person-circle mr-2"></i>{{ Auth::user()->name }}</a>
                    @else
                        <span class="block px-3 py-2 text-base font-bold text-gray-900 dark:text-white"><i class="bi bi-person-circle mr-2"></i>{{ Auth::user()->name }}</span>
                    @endif
                    <a href="{{ route('logout') }}" class="block px-3 py-2 text-base font-medium text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-md" onclick="event.preventDefault(); document.getElementById('public-logout-form-mobile').submit();">Keluar</a>
                    <form id="public-logout-form-mobile" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block w-full text-center px-4 py-2 border border-indigo-600 text-indigo-600 font-medium rounded-md mb-2">Masuk</a>
                    <a href="{{ route('register') }}" class="block w-full text-center px-4 py-2 bg-indigo-600 text-white font-medium rounded-md">Daftar</a>
                @endauth
            </div>
        </div>
    </div>
</nav>