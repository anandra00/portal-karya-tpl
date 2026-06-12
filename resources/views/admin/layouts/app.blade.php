<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - Portal TPL SV IPB</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS (via Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Unified Admin CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin/unified.css') }}">
    
    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>
    
    @stack('styles')
</head>
<body>
    <div class="admin-layout">
        <!-- Sidebar -->
        @include('admin.partials.sidebar')

        <!-- Sidebar Overlay (Mobile) -->
        <div class="sidebar-overlay" id="sidebar-overlay"></div>

        <div class="admin-main">
            <!-- Topbar -->
            @include('admin.partials.navbar')

            <!-- Main Content Area -->
            <main class="content-wrapper">
                @if(session('success'))
                    <div style="background-color: #D1FAE5; color: #065F46; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 8px; border: 1px solid #34D399;">
                        <i data-feather="check-circle" style="width: 18px; height: 18px;"></i>
                        {{ session('success') }}
                    </div>
                @endif
                
                @if(session('error'))
                    <div style="background-color: #FEE2E2; color: #991B1B; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 8px; border: 1px solid #F87171;">
                        <i data-feather="alert-circle" style="width: 18px; height: 18px;"></i>
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>

            <!-- Footer -->
            <footer class="admin-footer">
                <p>&copy; {{ date('Y') }} IPB University — Sekolah Vokasi. All Rights Reserved.</p>
            </footer>
        </div>
    </div>



    <!-- Initialize Icons -->
    <script>
        feather.replace();
        
        // Sidebar Toggle Logic for Mobile
        const menuToggle = document.getElementById('menu-toggle');
        const sidebar = document.querySelector('.admin-sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        
        function toggleSidebar() {
            if(sidebar) {
                sidebar.classList.toggle('show');
                if(overlay) overlay.classList.toggle('show');
            }
        }

        if(menuToggle) {
            menuToggle.addEventListener('click', toggleSidebar);
        }

        if(overlay) {
            overlay.addEventListener('click', toggleSidebar);
        }
    </script>
    
    @stack('scripts')
</body>
</html>
