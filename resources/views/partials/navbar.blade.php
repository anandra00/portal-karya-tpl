{{-- Premium Navbar — Smart Auto-Hide + Animated Hamburger --}}
<nav x-data="{ 
        mobileMenuOpen: false, 
        lastScrollTop: 0, 
        isHidden: false,
        atTop: true,
        init() {
            window.addEventListener('scroll', () => {
                const st = window.scrollY;
                this.atTop = st < 20;
                if (st > this.lastScrollTop && st > 100 && !this.mobileMenuOpen) {
                    this.isHidden = true;
                } else {
                    this.isHidden = false;
                }
                this.lastScrollTop = st;
            }, { passive: true });
        }
     }" 
     :class="{ '-translate-y-full': isHidden, 'shadow-lg': !atTop, 'shadow-sm': atTop }"
     class="fixed w-full z-50 bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl transition-all duration-500 border-b border-gray-200/50 dark:border-gray-800/50">
    <div class="w-full px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                <img src="{{ asset('images/logotpl.png') }}" alt="Logo TPL" class="h-12 w-auto group-hover:scale-105 transition-transform duration-300">
                <div class="hidden sm:block leading-tight">
                    <strong class="block text-lg text-indigo-900 dark:text-indigo-100 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">TPL SV IPB</strong>
                    <small class="block text-sm font-medium text-indigo-600 dark:text-indigo-400">Teknologi Rekayasa Perangkat Lunak</small>
                </div>
            </a>

            <!-- Desktop Menu -->
            <div class="hidden lg:flex lg:items-center lg:space-x-1">
                @php
                    $navLinks = [
                        ['route' => 'home', 'label' => 'Beranda', 'check' => request()->routeIs('home')],
                        ['route' => 'karya.public', 'label' => 'Karya', 'check' => request()->routeIs('karya.public') || request()->routeIs('karya.public.show')],
                        ['route' => 'tentang', 'label' => 'Tentang', 'check' => request()->routeIs('tentang')],
                        ['route' => 'homepage.dosen', 'label' => 'Dosen', 'check' => request()->routeIs('homepage.dosen')],
                        ['route' => 'matakuliah.user', 'label' => 'Mata Kuliah', 'check' => request()->routeIs('matakuliah.user')],
                        ['route' => 'faq', 'label' => 'FAQ', 'check' => request()->routeIs('faq')],
                    ];
                @endphp

                @foreach ($navLinks as $link)
                <a href="{{ route($link['route']) }}" 
                   class="relative px-4 py-2 rounded-xl text-sm font-semibold transition-all duration-300 
                          {{ $link['check'] 
                              ? 'text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-950/40' 
                              : 'text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-gray-50 dark:hover:bg-gray-800/50' }}">
                    {{ $link['label'] }}
                    @if($link['check'])
                    <span class="absolute bottom-0 left-1/2 -translate-x-1/2 w-5 h-0.5 bg-gradient-to-r from-indigo-600 to-purple-600 dark:from-indigo-400 dark:to-purple-400 rounded-full"></span>
                    @endif
                </a>
                @endforeach

                <div class="w-px h-6 bg-gray-200 dark:bg-gray-700 mx-2"></div>

                <!-- Theme Toggle -->
                <button id="theme-toggle" class="theme-toggle-btn text-gray-500 hover:text-yellow-500 focus:outline-none p-2 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-800 transition-all">
                    <i class="bi bi-moon-stars-fill text-lg" id="theme-icon"></i>
                </button>

                <!-- Google Translate Hidden Engine -->
                <div id="google_translate_element"></div>

                <!-- Custom Language Switcher -->
                <div class="relative flex items-center">
                    <div class="flex items-center gap-1 bg-indigo-50 dark:bg-indigo-900/30 border border-indigo-200/50 dark:border-indigo-800/50 rounded-xl px-2.5 py-1.5 cursor-pointer hover:bg-indigo-100 dark:hover:bg-indigo-900/50 transition-all shadow-sm hover:shadow-md">
                        <i class="bi bi-translate text-indigo-600 dark:text-indigo-400 text-sm"></i>
                        <select class="custom-language-selector bg-transparent border-none text-xs font-bold text-indigo-700 dark:text-indigo-300 focus:ring-0 cursor-pointer outline-none pl-1 pr-5 appearance-none" style="background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22%234F46E5%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3e%3cpolyline points=%226 9 12 15 18 9%22%3e%3c/polyline%3e%3c/svg%3e'); background-repeat: no-repeat; background-position: right center; background-size: 12px;">
                            <option value="id">ID</option>
                            <option value="en">EN</option>
                        </select>
                    </div>
                </div>

                <div class="w-px h-6 bg-gray-200 dark:bg-gray-700 mx-2"></div>

                @auth
                    <!-- Notifications Dropdown -->
                    @php
                        $unreadCount = Auth::user()->unreadNotifications->count();
                        $recentNotifications = Auth::user()->notifications()->take(5)->get();
                    @endphp
                    <div x-data="{ 
                        open: false,
                        unreadCount: {{ $unreadCount }},
                        notifications: [
                            @foreach($recentNotifications as $n)
                            {
                                id: '{{ $n->id }}',
                                message: '{{ e($n->data['message'] ?? '') }}',
                                link: '{{ e($n->data['link'] ?? '#') }}',
                                read: {{ $n->read_at ? 'true' : 'false' }},
                                created_at: '{{ $n->created_at->diffForHumans() }}'
                            },
                            @endforeach
                        ],
                        init() {
                            document.addEventListener('DOMContentLoaded', () => {
                                if (window.Echo) {
                                    window.Echo.private('App.Models.User.{{ Auth::id() }}')
                                        .notification((notification) => {
                                            this.unreadCount++;
                                            this.notifications.unshift({
                                                id: notification.id,
                                                message: notification.message,
                                                link: notification.link || '#',
                                                read: false,
                                                created_at: 'Baru saja'
                                            });
                                            if (this.notifications.length > 5) {
                                                this.notifications.pop();
                                            }
                                            
                                            if (window.showNotificationToast) {
                                                window.showNotificationToast(notification.message, notification.link);
                                            }
                                        });
                                }
                            });
                        },
                        markAllAsRead() {
                            fetch('{{ route('notifications.read-all') }}', {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json'
                                }
                            }).then(res => {
                                if (res.ok) {
                                    this.unreadCount = 0;
                                    this.notifications.forEach(n => n.read = true);
                                }
                            });
                        }
                    }" class="relative flex items-center" @click.outside="open = false">
                        <button @click="open = !open" class="relative text-gray-500 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-indigo-400 focus:outline-none p-2 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-800 transition-all mr-1">
                            <i class="bi bi-bell text-lg"></i>
                            <span x-show="unreadCount > 0" x-text="unreadCount" class="absolute top-1 right-1 flex h-4 min-w-4 items-center justify-center rounded-full bg-red-500 px-1 text-[9px] font-extrabold text-white animate-pulse"></span>
                        </button>
                        
                        <!-- Dropdown Panel -->
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             style="display: none;"
                             class="absolute right-0 mt-2 top-full w-80 rounded-2xl bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 shadow-xl z-50 overflow-hidden">
                            <div class="flex justify-between items-center px-4 py-3 bg-gray-50 dark:bg-gray-700/50 border-b border-gray-100 dark:border-gray-700">
                                <span class="text-xs font-bold text-gray-700 dark:text-gray-200">Notifikasi</span>
                                <button x-show="unreadCount > 0" @click="markAllAsRead()" class="text-[10px] text-indigo-600 dark:text-indigo-400 hover:underline">Tandai dibaca</button>
                            </div>
                            <div class="max-h-64 overflow-y-auto divide-y divide-gray-100 dark:divide-gray-700">
                                <template x-if="notifications.length === 0">
                                    <div class="px-4 py-6 text-center text-xs text-gray-400 dark:text-gray-500">Tidak ada notifikasi baru</div>
                                </template>
                                <template x-for="n in notifications" :key="n.id">
                                    <a :href="n.link" class="block px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-750 transition-colors" :class="{'bg-indigo-50/20 dark:bg-indigo-950/10 font-semibold': !n.read}">
                                        <p x-text="n.message" class="text-[11px] text-gray-600 dark:text-gray-300 line-clamp-2 leading-snug"></p>
                                        <span x-text="n.created_at" class="text-[9px] text-gray-400 dark:text-gray-500 block mt-1"></span>
                                    </a>
                                </template>
                            </div>
                        </div>
                    </div>

                    @if(Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin')
                        <a href="{{ route('dashboard') }}" class="px-4 py-2 rounded-xl text-sm font-bold text-gray-700 dark:text-white flex items-center hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-all">
                            <i class="bi bi-speedometer2 mr-2"></i>Dashboard
                        </a>
                    @endif
                    <a href="{{ route('profile.edit') }}" class="px-4 py-2 rounded-xl text-sm font-bold text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition-all flex items-center hover:bg-gray-50 dark:hover:bg-gray-800/50">
                        <i class="bi bi-person-circle mr-1.5"></i>Profil
                    </a>
                    <a href="{{ route('logout') }}" class="px-4 py-2 rounded-xl text-sm text-red-500 hover:text-red-700 hover:bg-red-50 dark:hover:bg-red-900/20 font-semibold transition-all flex items-center" onclick="event.preventDefault(); document.getElementById('public-logout-form').submit();">
                        <i class="bi bi-box-arrow-right mr-1"></i>Keluar
                    </a>
                    <form id="public-logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @else
                    <a href="{{ route('login') }}" class="px-5 py-2 text-sm text-indigo-600 border border-indigo-200 dark:border-indigo-800 font-semibold rounded-xl hover:bg-indigo-50 dark:hover:bg-indigo-950/30 transition-all">Masuk</a>
                    <a href="{{ route('register') }}" class="px-5 py-2 text-sm bg-gradient-to-r from-indigo-600 to-indigo-700 text-white font-semibold rounded-xl hover:from-indigo-700 hover:to-indigo-800 shadow-md hover:shadow-lg transition-all hover:-translate-y-0.5">Daftar</a>
                @endauth
            </div>

            <!-- Mobile menu button — Animated Hamburger -->
            <div class="flex lg:hidden items-center space-x-3">
                <button id="theme-toggle-mobile" class="theme-toggle-btn text-gray-500 hover:text-yellow-500 focus:outline-none p-2 rounded-xl transition-all">
                    <i class="bi bi-moon-stars-fill text-lg" id="theme-icon-mobile"></i>
                </button>
                <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="relative w-10 h-10 flex items-center justify-center rounded-xl text-gray-500 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none transition-all">
                    <span class="sr-only">Toggle menu</span>
                    <div class="w-5 flex flex-col items-center justify-center gap-[5px]">
                        <span class="w-full h-[2px] bg-current rounded-full transition-all duration-300 origin-center"
                              :class="mobileMenuOpen ? 'rotate-45 translate-y-[7px]' : ''"></span>
                        <span class="w-full h-[2px] bg-current rounded-full transition-all duration-300"
                              :class="mobileMenuOpen ? 'opacity-0 scale-x-0' : ''"></span>
                        <span class="w-full h-[2px] bg-current rounded-full transition-all duration-300 origin-center"
                              :class="mobileMenuOpen ? '-rotate-45 -translate-y-[7px]' : ''"></span>
                    </div>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu — Full Overlay -->
    <div x-show="mobileMenuOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-4"
         class="lg:hidden bg-white/95 dark:bg-gray-900/95 backdrop-blur-xl border-t border-gray-200/50 dark:border-gray-800/50 shadow-2xl" 
         style="display: none;">
        <div class="px-4 pt-4 pb-6 space-y-1 max-h-[80vh] overflow-y-auto">
            @foreach ($navLinks as $link)
            <a href="{{ route($link['route']) }}" 
               class="flex items-center px-4 py-3 rounded-xl text-base font-medium transition-all duration-200
                      {{ $link['check'] 
                          ? 'text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-950/40' 
                          : 'text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800/50' }}">
                {{ $link['label'] }}
                @if($link['check'])
                <i class="bi bi-dot text-indigo-500 ml-auto text-2xl"></i>
                @endif
            </a>
            @endforeach

            <div class="px-3 py-3 flex items-center gap-3 border-t border-gray-100 dark:border-gray-800 mt-2 pt-4">
                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Bahasa:</span>
                <div id="google_translate_element_mobile"></div>
                <div class="flex items-center gap-1 bg-indigo-50 dark:bg-indigo-900/30 border border-indigo-200/50 dark:border-indigo-800/50 rounded-xl px-2.5 py-1.5 cursor-pointer">
                    <i class="bi bi-translate text-indigo-600 dark:text-indigo-400 text-sm"></i>
                    <select class="custom-language-selector bg-transparent border-none text-xs font-bold text-indigo-700 dark:text-indigo-300 focus:ring-0 cursor-pointer outline-none pl-1 pr-5 appearance-none" style="background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22%234F46E5%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3e%3cpolyline points=%226 9 12 15 18 9%22%3e%3c/polyline%3e%3c/svg%3e'); background-repeat: no-repeat; background-position: right center; background-size: 12px;">
                        <option value="id">ID</option>
                        <option value="en">EN</option>
                    </select>
                </div>
            </div>

            <div class="border-t border-gray-100 dark:border-gray-800 pt-4 space-y-1">
                @auth
                    @if(Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin')
                        <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 rounded-xl text-base font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-all"><i class="bi bi-speedometer2 mr-3 text-indigo-500"></i>Dashboard</a>
                    @endif
                    <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-3 rounded-xl text-base font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-all"><i class="bi bi-person-circle mr-3 text-indigo-500"></i>Profil</a>
                    <a href="{{ route('logout') }}" class="flex items-center px-4 py-3 text-base font-medium text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-xl transition-all" onclick="event.preventDefault(); document.getElementById('public-logout-form-mobile').submit();"><i class="bi bi-box-arrow-right mr-3"></i>Keluar</a>
                    <form id="public-logout-form-mobile" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @else
                    <div class="flex gap-3 pt-2">
                        <a href="{{ route('login') }}" class="flex-1 text-center px-4 py-3 border border-indigo-200 dark:border-indigo-800 text-indigo-600 dark:text-indigo-400 font-semibold rounded-xl hover:bg-indigo-50 dark:hover:bg-indigo-950/30 transition-all">Masuk</a>
                        <a href="{{ route('register') }}" class="flex-1 text-center px-4 py-3 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white font-semibold rounded-xl shadow-md transition-all">Daftar</a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>