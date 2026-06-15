{{-- Hero Section Partial — Used across all public pages --}}
{{-- Usage: @include('partials.hero', ['title' => '...', 'subtitle' => '...']) --}}
<section class="relative overflow-hidden bg-gradient-to-r from-indigo-950 via-indigo-850 to-indigo-950 dark:from-gray-950 dark:via-gray-900 dark:to-gray-950 text-white text-center pt-36 pb-20 sm:pt-48 sm:pb-28">
    <!-- Floating Organic background blobs -->
    <div class="absolute -top-12 -left-12 w-72 h-72 bg-purple-500/10 rounded-full filter blur-2xl animate-blob pointer-events-none"></div>
    <div class="absolute -bottom-16 -right-16 w-80 h-80 bg-blue-500/10 rounded-full filter blur-2xl animate-blob animation-delay-2000 pointer-events-none"></div>
    <div class="absolute top-1/2 left-1/3 w-64 h-64 bg-indigo-500/8 rounded-full filter blur-2xl animate-blob animation-delay-4000 pointer-events-none"></div>

    <!-- Decorative background elements -->
    <div class="absolute inset-0 opacity-15 pointer-events-none" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 32px 32px;"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Premium Badge -->
        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/10 dark:bg-white/5 backdrop-blur-md border border-white/20 dark:border-white/10 mb-6 text-xs sm:text-sm font-semibold text-indigo-100 hover:bg-white/15 dark:hover:bg-white/10 transition-all duration-300 transform hover:scale-105 select-none cursor-pointer fade-in-up">
            <span class="flex h-2 w-2 relative">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
            </span>
            <span>Karya Digital & Inovasi Teknologi</span>
        </div>

        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-transparent bg-clip-text bg-gradient-to-r from-indigo-100 via-white to-blue-100 dark:from-indigo-200 dark:via-white dark:to-blue-200 py-1.5 fade-in-up" style="animation-delay: 0.1s;">
            {{ $title ?? 'Portal Teknologi Rekayasa Perangkat Lunak' }}
        </h1>
        
        <p class="mt-6 text-lg sm:text-xl md:text-2xl max-w-3xl mx-auto font-medium text-indigo-100 dark:text-gray-300 fade-in-up" style="animation-delay: 0.2s;">
            {{ $subtitle ?? 'Sekolah Vokasi IPB University' }}
        </p>
    </div>
</section>
