<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Portal TPL SVIPB'))</title>
    @yield('meta')

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Outfit', sans-serif !important; }
    </style>
    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">


    {{-- Laravel default styles --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Global UI (Navbar, Fonts, Typography) --}}
    <link rel="stylesheet" href="{{ asset('css/global-ui.css') }}">

    {{-- Custom CSS (khusus halaman anak) --}}
    @stack('styles')
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen d-flex flex-column">
        {{-- 🔹 NAVBAR --}}
        @include('partials.navbar')

        {{-- 🔹 HERO SECTION (kalau ada di halaman anak) --}}
        @yield('hero')

        {{-- 🔹 MAIN CONTENT --}}
        <main class="flex-grow-1">
            @yield('content')
        </main>

        {{-- 🔹 FOOTER (opsional, bisa dikosongkan dulu) --}}
        @include('partials.footer')

        {{-- Scripts --}}
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>

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

                // Observe all .fade-in-up elements NOT inside hero section
                document.querySelectorAll('.fade-in-up:not(.hero-section .fade-in-up)').forEach(el => {
                    observer.observe(el);
                });
            });
        </script>

        @stack('scripts')
    </div>
</body>

</html>