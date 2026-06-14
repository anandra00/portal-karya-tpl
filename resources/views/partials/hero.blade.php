{{-- Hero Section Partial — Used across all public pages --}}
{{-- Usage: @include('partials.hero', ['title' => '...', 'subtitle' => '...']) --}}
<section class="relative overflow-hidden bg-gradient-to-r from-indigo-900 via-indigo-700 to-indigo-900 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 text-white text-center pt-36 pb-20 sm:pt-48 sm:pb-28">
    <!-- Decorative background elements -->
    <div class="absolute inset-0 opacity-20 pointer-events-none" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 32px 32px;"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight fade-in-up" style="animation-delay: 0.1s;">
            {{ $title ?? 'Portal Teknologi Rekayasa Perangkat Lunak' }}
        </h1>
        <p class="mt-6 text-lg sm:text-xl md:text-2xl max-w-3xl mx-auto font-medium text-indigo-100 dark:text-gray-300 fade-in-up" style="animation-delay: 0.2s;">
            {{ $subtitle ?? 'Sekolah Vokasi IPB University' }}
        </p>
    </div>
</section>
