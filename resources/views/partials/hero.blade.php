{{-- Hero Section Partial — Used across all public pages --}}
{{-- Usage: @include('partials.hero', ['title' => '...', 'subtitle' => '...']) --}}
<section class="hero-section text-white text-center py-5 position-relative overflow-hidden">
    <div class="container position-relative" style="z-index: 2;">
        <h1 class="display-4 fw-bold fade-in-up" style="animation-delay: 0.1s;">
            {{ $title ?? 'Selamat Datang Di Portal Teknologi Rekayasa Perangkat Lunak SV IPB' }}
        </h1>
        <p class="lead mt-3 fade-in-up" style="animation-delay: 0.2s;">
            {{ $subtitle ?? 'Syntax Error Compile Lagi' }}
        </p>
    </div>
</section>
