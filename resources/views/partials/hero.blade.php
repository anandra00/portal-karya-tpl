{{-- Premium Cinematic Hero Section — Used across all public pages --}}
{{-- Usage: @include('partials.hero', ['title' => '...', 'subtitle' => '...']) --}}
<section class="relative overflow-hidden bg-gradient-to-br from-indigo-950 via-indigo-900 to-blue-950 dark:from-gray-950 dark:via-gray-900 dark:to-gray-950 text-white text-center pt-36 pb-20 sm:pt-48 sm:pb-28">
    
    {{-- Animated Particle Grid --}}
    <div class="absolute inset-0 opacity-[0.08] pointer-events-none" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 40px 40px;"></div>
    
    {{-- Floating Organic background blobs --}}
    <div class="absolute -top-20 -left-20 w-96 h-96 bg-purple-500/10 rounded-full filter blur-3xl animate-blob pointer-events-none"></div>
    <div class="absolute -bottom-20 -right-20 w-[28rem] h-[28rem] bg-blue-500/10 rounded-full filter blur-3xl animate-blob animation-delay-2000 pointer-events-none"></div>
    <div class="absolute top-1/3 left-1/4 w-72 h-72 bg-indigo-400/8 rounded-full filter blur-3xl animate-blob animation-delay-4000 pointer-events-none"></div>
    
    {{-- Morphing accent shape --}}
    <div class="absolute top-1/2 right-1/4 w-48 h-48 bg-gradient-to-br from-indigo-500/10 to-purple-500/10 animate-morph pointer-events-none"></div>

    {{-- Gradient Orb Glow --}}
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-gradient-to-r from-indigo-600/5 via-purple-500/5 to-blue-500/5 rounded-full blur-3xl pointer-events-none animate-pulse"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        {{-- Premium Status Badge --}}
        <div class="inline-flex items-center gap-2.5 px-4 py-2 rounded-full bg-white/[0.08] backdrop-blur-xl border border-white/[0.12] mb-8 text-xs sm:text-sm font-semibold text-indigo-100 hover:bg-white/[0.12] transition-all duration-300 transform hover:scale-105 select-none cursor-pointer fade-in-up shimmer">
            <span class="flex h-2.5 w-2.5 relative">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
            </span>
            <span>Karya Digital & Inovasi Teknologi</span>
            <i class="bi bi-arrow-right text-indigo-300 ml-1"></i>
        </div>

        {{-- Animated Gradient Title --}}
        <h1 class="text-4xl sm:text-5xl lg:text-6xl xl:text-7xl font-extrabold tracking-tight py-2 fade-in-up" style="animation-delay: 0.1s;">
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-white via-indigo-100 to-blue-100 dark:from-indigo-200 dark:via-white dark:to-blue-200" style="background-size: 200% auto; animation: gradient-shift 4s ease infinite;">
                {{ $title ?? 'Portal Teknologi Rekayasa Perangkat Lunak' }}
            </span>
        </h1>
        
        {{-- Subtitle --}}
        <p class="mt-6 text-lg sm:text-xl md:text-2xl max-w-3xl mx-auto font-medium text-indigo-200/90 dark:text-gray-300 fade-in-up leading-relaxed" style="animation-delay: 0.2s;">
            {{ $subtitle ?? 'Sekolah Vokasi IPB University' }}
        </p>

        {{-- Decorative bottom line --}}
        <div class="mt-10 flex justify-center gap-2 fade-in-up" style="animation-delay: 0.3s;">
            <span class="w-12 h-1 rounded-full bg-indigo-400/60"></span>
            <span class="w-4 h-1 rounded-full bg-indigo-400/40"></span>
            <span class="w-2 h-1 rounded-full bg-indigo-400/20"></span>
        </div>
    </div>

    {{-- Bottom gradient fade to content --}}
    <div class="absolute bottom-0 left-0 right-0 h-24 bg-gradient-to-t from-gray-50 dark:from-gray-900 to-transparent pointer-events-none"></div>
</section>
