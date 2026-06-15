<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Portal TPL SVIPB'))</title>
    @yield('meta')
    
    {{-- Favicon TPL --}}
    <link rel="icon" type="image/png" href="{{ asset('images/logo_TPL.png') }}">
    
    {{-- PWA Manifest & Theme Color --}}
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#4F46E5">

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        html {
            scroll-behavior: smooth;
        }
        body { font-family: 'Outfit', sans-serif !important; }
        
        /* Custom Fade In Up Animation */
        .fade-in-up {
            opacity: 0;
            transform: translateY(15px);
            transition: opacity 0.6s cubic-bezier(0.16, 1, 0.3, 1), transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
            will-change: opacity, transform;
        }
        .fade-in-up.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Floating Organic Blobs Animation */
        @keyframes blob {
            0% { transform: translate3d(0px, 0px, 0px) scale(1); }
            33% { transform: translate3d(20px, -30px, 0px) scale(1.06); }
            66% { transform: translate3d(-15px, 15px, 0px) scale(0.96); }
            100% { transform: translate3d(0px, 0px, 0px) scale(1); }
        }
        .animate-blob {
            animation: blob 12s infinite ease-in-out;
            will-change: transform;
            backface-visibility: hidden;
            -webkit-backface-visibility: hidden;
            transform: translate3d(0, 0, 0);
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        .animation-delay-4000 {
            animation-delay: 4s;
        }

        /* High-Fidelity Glow Cards & Transitions */
        .karya-card, .dosen-card {
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1) !important;
        }
        .karya-card:hover {
            transform: translateY(-6px) scale(1.02);
            box-shadow: 0 20px 25px -5px rgba(79, 70, 229, 0.15), 0 10px 10px -5px rgba(79, 70, 229, 0.08);
            border-color: rgba(99, 102, 241, 0.4) !important;
        }
        .dark .karya-card:hover {
            box-shadow: 0 20px 25px -5px rgba(99, 102, 241, 0.25), 0 10px 10px -5px rgba(99, 102, 241, 0.12);
            border-color: rgba(99, 102, 241, 0.5) !important;
        }

        .dosen-card:hover {
            transform: translateY(-6px) scale(1.02);
            box-shadow: 0 20px 25px -5px rgba(16, 185, 129, 0.15), 0 10px 10px -5px rgba(16, 185, 129, 0.08);
            border-color: rgba(16, 185, 129, 0.4) !important;
        }
        .dark .dosen-card:hover {
            box-shadow: 0 20px 25px -5px rgba(16, 185, 129, 0.25), 0 10px 10px -5px rgba(16, 185, 129, 0.12);
            border-color: rgba(16, 185, 129, 0.5) !important;
        }

        /* Google Translate Customization - HIDDEN */
        body { top: 0px !important; position: static !important; }
        .goog-te-banner-frame { display: none !important; visibility: hidden !important; }
        .skiptranslate { display: none !important; }
        #goog-gt-tt { display: none !important; visibility: hidden !important; }
        .goog-tooltip { display: none !important; }
        .goog-tooltip:hover { display: none !important; }
        .goog-text-highlight { background-color: transparent !important; box-shadow: none !important; border: none !important; }
        
        #google_translate_element, #google_translate_element_mobile {
            opacity: 0 !important;
            position: absolute !important;
            left: -9999px !important;
            z-index: -999 !important;
            width: 1px !important;
            height: 1px !important;
            overflow: hidden !important;
        }
    </style>
    
    {{-- Alpine.js --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- Tailwind via Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Custom CSS (khusus halaman anak) --}}
    @stack('styles')

    {{-- Dark Mode Init (Prevent Flash) --}}
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>

<body class="font-sans antialiased text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-900 transition-colors duration-300 flex flex-col min-h-screen">
    <!-- Global Toast Notification -->
    <div x-data="{ 
             show: false, 
             message: '', 
             type: 'success',
             initToast() {
                 @if(session('success'))
                     this.showToast('{{ addslashes(session('success')) }}', 'success');
                 @elseif(session('error'))
                     this.showToast('{{ addslashes(session('error')) }}', 'error');
                 @endif
             },
             showToast(msg, type = 'success') {
                 this.message = msg;
                 this.type = type;
                 this.show = true;
                 setTimeout(() => { this.show = false }, 4000);
             }
         }" 
         x-init="initToast()"
         x-show="show"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-2 sm:translate-y-0 sm:translate-x-2"
         x-transition:enter-end="opacity-100 translate-y-0 sm:translate-x-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed top-24 right-4 z-50 max-w-sm w-full bg-white dark:bg-gray-800 shadow-xl rounded-2xl border border-gray-100 dark:border-gray-700 p-4 flex items-start gap-3 pointer-events-auto"
         style="display: none;"
    >
        <div class="flex-shrink-0">
            <template x-if="type === 'success'">
                <i class="bi bi-check-circle-fill text-green-500 text-xl"></i>
            </template>
            <template x-if="type === 'error'">
                <i class="bi bi-exclamation-triangle-fill text-red-500 text-xl"></i>
            </template>
        </div>
        <div class="flex-grow pt-0.5">
            <p class="text-sm font-bold text-gray-900 dark:text-white" x-text="type === 'success' ? 'Berhasil' : 'Error'"></p>
            <p class="text-xs text-gray-600 dark:text-gray-400 mt-1" x-text="message"></p>
        </div>
        <button @click="show = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 focus:outline-none">
            <i class="bi bi-x-lg text-sm"></i>
        </button>
    </div>

    {{-- NAVBAR --}}
    @include('partials.navbar')

    {{-- HERO SECTION (kalau ada di halaman anak) --}}
    @yield('hero')

    {{-- MAIN CONTENT --}}
    <main class="flex-grow">
        @yield('content')
        @isset($slot)
            {{ $slot }}
        @endisset
    </main>

    {{-- FOOTER --}}
    @include('partials.footer')



        {{-- Scroll Animation (Intersection Observer) --}}
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach((entry) => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('visible');
                            observer.unobserve(entry.target);
                        }
                    });
                }, {
                    threshold: 0.05,
                    rootMargin: '0px 0px -20px 0px'
                });

                // Observe all .fade-in-up elements
                document.querySelectorAll('.fade-in-up').forEach(el => {
                    observer.observe(el);
                });
            });
        </script>

        {{-- Dark Mode Toggle Logic --}}
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const toggleBtns = [document.getElementById('theme-toggle'), document.getElementById('theme-toggle-mobile')];
                const icons = [document.getElementById('theme-icon'), document.getElementById('theme-icon-mobile')];
                
                // Set initial icon
                if (document.documentElement.classList.contains('dark')) {
                    icons.forEach(icon => {
                        if(icon) {
                            icon.classList.replace('bi-moon-stars-fill', 'bi-sun-fill');
                            icon.classList.add('text-yellow-400');
                        }
                    });
                }

                toggleBtns.forEach(btn => {
                    if (btn) {
                        btn.addEventListener('click', () => {
                            const isDark = document.documentElement.classList.contains('dark');
                            if (isDark) {
                                document.documentElement.classList.remove('dark');
                                localStorage.setItem('theme', 'light');
                                icons.forEach(icon => {
                                    if(icon) {
                                        icon.classList.replace('bi-sun-fill', 'bi-moon-stars-fill');
                                        icon.classList.remove('text-yellow-400');
                                    }
                                });
                            } else {
                                document.documentElement.classList.add('dark');
                                localStorage.setItem('theme', 'dark');
                                icons.forEach(icon => {
                                    if(icon) {
                                        icon.classList.replace('bi-moon-stars-fill', 'bi-sun-fill');
                                        icon.classList.add('text-yellow-400');
                                    }
                                });
                            }
                        });
                    }
                });
            });
        </script>

        {{-- PWA Service Worker Registration --}}
        <script>
            if ('serviceWorker' in navigator) {
                window.addEventListener('load', function() {
                    navigator.serviceWorker.register('/sw.js').then(function(registration) {
                        console.log('ServiceWorker registration successful with scope: ', registration.scope);
                    }, function(err) {
                        console.log('ServiceWorker registration failed: ', err);
                    });
                });
            }
        </script>

        {{-- BFCache Workaround (Force Reload on Back Button) --}}
        <script>
            window.addEventListener('pageshow', function (event) {
                if (event.persisted) {
                    window.location.reload();
                }
            });
        </script>

        @stack('scripts')
    <script>
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'id', 
                includedLanguages: 'id,en', 
                layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
                autoDisplay: false
            }, 'google_translate_element');
            
            // For mobile menu
            new google.translate.TranslateElement({
                pageLanguage: 'id', 
                includedLanguages: 'id,en', 
                layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
                autoDisplay: false
            }, 'google_translate_element_mobile');
        }
        
        // Custom Language Switcher Logic
        function changeCustomLanguage(lang) {
            let select = document.querySelector('.goog-te-combo');
            if (select) {
                select.value = lang;
                select.dispatchEvent(new Event('change', { bubbles: true, cancelable: true }));
            } else {
                // Fallback
                document.cookie = `googtrans=/id/${lang}; path=/;`;
                window.location.reload();
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Check current language from cookie
            let currentLang = 'id';
            const match = document.cookie.match(/googtrans=\/id\/([a-z]{2})/);
            if (match) currentLang = match[1];

            document.querySelectorAll('.custom-language-selector').forEach(selector => {
                selector.value = currentLang;
                selector.addEventListener('change', function() {
                    changeCustomLanguage(this.value);
                });
            });
        });
    </script>
    <script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

</body>
</html>