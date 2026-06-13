<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Portal TPL SVIPB'))</title>
    @yield('meta')
    
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
        body { font-family: 'Outfit', sans-serif !important; }
        
        /* Custom Fade In Up Animation */
        .fade-in-up {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.8s ease-out, transform 0.8s ease-out;
            will-change: opacity, transform;
        }
        .fade-in-up.visible {
            opacity: 1;
            transform: translateY(0);
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
    {{-- 🔹 NAVBAR --}}
    @include('partials.navbar')

    {{-- 🔹 HERO SECTION (kalau ada di halaman anak) --}}
    @yield('hero')

    {{-- 🔹 MAIN CONTENT --}}
    <main class="flex-grow">
        @yield('content')
    </main>

    {{-- 🔹 FOOTER --}}
    @include('partials.footer')



        {{-- Scroll Animation (Intersection Observer) --}}
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach((entry, index) => {
                        if (entry.isIntersecting) {
                            // Stagger animation delay based on order
                            const delay = index * 100;
                            setTimeout(() => {
                                entry.target.classList.add('visible');
                            }, delay);
                            observer.unobserve(entry.target);
                        }
                    });
                }, {
                    threshold: 0.1,
                    rootMargin: '0px 0px -50px 0px'
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