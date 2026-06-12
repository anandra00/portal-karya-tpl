<nav x-data="{ mobileMenuOpen: false }" class="fixed w-full z-50 bg-white/80 dark:bg-gray-900/80 backdrop-blur-md shadow-sm transition-all duration-300 border-b border-gray-200 dark:border-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
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
                <a href="{{ route('home') }}" class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 font-semibold transition {{ request()->routeIs('home') ? 'text-indigo-600 dark:text-indigo-400' : '' }}">Home</a>
                <a href="{{ route('tentang') }}" class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 font-semibold transition {{ request()->routeIs('tentang') ? 'text-indigo-600 dark:text-indigo-400' : '' }}">Tentang</a>
                <a href="{{ route('homepage.dosen') }}" class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 font-semibold transition {{ request()->routeIs('homepage.dosen') ? 'text-indigo-600 dark:text-indigo-400' : '' }}">Dosen</a>
                <a href="{{ route('matakuliah.user') }}" class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 font-semibold transition {{ request()->routeIs('matakuliah.user') ? 'text-indigo-600 dark:text-indigo-400' : '' }}">Mata Kuliah</a>
                <a href="{{ route('faq') }}" class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 font-semibold transition {{ request()->routeIs('faq') ? 'text-indigo-600 dark:text-indigo-400' : '' }}">FAQ</a>

                <!-- Theme Toggle -->
                <button id="theme-toggle" class="text-gray-500 hover:text-yellow-500 focus:outline-none transition">
                    <i class="bi bi-moon-stars-fill text-lg" id="theme-icon"></i>
                </button>

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
                    <a href="{{ route('logout') }}" class="text-red-500 hover:text-red-700 font-semibold transition flex items-center">
                        <i class="bi bi-box-arrow-right mr-1"></i>Logout
                    </a>
                @else
                    <a href="{{ route('login') }}" class="px-5 py-2 text-indigo-600 border border-indigo-600 font-semibold rounded-lg hover:bg-indigo-50 transition">Login</a>
                    <a href="{{ route('register') }}" class="px-5 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 shadow-md transition">Register</a>
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
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-900 dark:text-white hover:bg-gray-50 dark:hover:bg-gray-800">Home</a>
            <a href="{{ route('tentang') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-900 dark:text-white hover:bg-gray-50 dark:hover:bg-gray-800">Tentang</a>
            <a href="{{ route('homepage.dosen') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-900 dark:text-white hover:bg-gray-50 dark:hover:bg-gray-800">Dosen</a>
            <a href="{{ route('matakuliah.user') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-900 dark:text-white hover:bg-gray-50 dark:hover:bg-gray-800">Mata Kuliah</a>
            <a href="{{ route('faq') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-900 dark:text-white hover:bg-gray-50 dark:hover:bg-gray-800">FAQ</a>

            <div class="border-t border-gray-200 dark:border-gray-700 pt-4 pb-2">
                @auth
                    @if(Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin')
                        <a href="{{ route('dashboard') }}" class="block px-3 py-2 text-base font-bold text-gray-900 dark:text-white"><i class="bi bi-person-circle mr-2"></i>{{ Auth::user()->name }}</a>
                    @else
                        <span class="block px-3 py-2 text-base font-bold text-gray-900 dark:text-white"><i class="bi bi-person-circle mr-2"></i>{{ Auth::user()->name }}</span>
                    @endif
                    <a href="{{ route('logout') }}" class="block px-3 py-2 text-base font-medium text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-md">Logout</a>
                @else
                    <a href="{{ route('login') }}" class="block w-full text-center px-4 py-2 border border-indigo-600 text-indigo-600 font-medium rounded-md mb-2">Login</a>
                    <a href="{{ route('register') }}" class="block w-full text-center px-4 py-2 bg-indigo-600 text-white font-medium rounded-md">Register</a>
                @endauth
            </div>
        </div>
    </div>
</nav>