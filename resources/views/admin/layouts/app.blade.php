<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - Portal TPL SV IPB</title>
    
    {{-- Favicon TPL --}}
    <link rel="icon" type="image/png" href="{{ asset('images/logo_TPL.png') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Unified Admin CSS (standalone, no Tailwind needed) -->
    <link rel="stylesheet" href="{{ asset('css/admin/unified.css') }}">
    
    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Dark Mode Init (Prevent Flash) -->
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    
    @stack('styles')
    
    <style>
        /* Google Translate Customization - HIDDEN */
        body { top: 0px !important; position: static !important; }
        .goog-te-banner-frame { display: none !important; visibility: hidden !important; }
        .skiptranslate { display: none !important; }
        #goog-gt-tt { display: none !important; visibility: hidden !important; }
        .goog-tooltip { display: none !important; }
        .goog-tooltip:hover { display: none !important; }
        .goog-text-highlight { background-color: transparent !important; box-shadow: none !important; border: none !important; }
        
        #google_translate_element_admin {
            opacity: 0 !important;
            position: absolute !important;
            left: -9999px !important;
            z-index: -999 !important;
            width: 1px !important;
            height: 1px !important;
            overflow: hidden !important;
        }
        
        /* Custom Select for Admin */
        .admin-custom-lang {
            padding: 4px 24px 4px 8px;
            border-radius: 4px;
            border: 1px solid #E5E7EB;
            background-color: white;
            color: #4F46E5;
            font-size: 0.8rem;
            font-weight: 600;
            outline: none;
            cursor: pointer;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%234F46E5' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 6px center;
            background-size: 12px;
        }
    </style>
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

    <!-- SweetAlert2 for Delete Confirmation Modals -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteForms = document.querySelectorAll('.delete-form');
            deleteForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault(); // Prevent standard form submission
                    
                    const itemName = this.getAttribute('data-name') || 'Item ini';
                    
                    Swal.fire({
                        title: 'Konfirmasi Hapus',
                        html: `Apakah Anda yakin ingin menghapus <b>${itemName}</b>?<br>Data yang dihapus tidak dapat dikembalikan.`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#EF4444', // var(--danger)
                        cancelButtonColor: '#6B7280', // var(--text-muted)
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal',
                        reverseButtons: true,
                        customClass: {
                            popup: 'swal2-custom-popup'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.submit(); // Submit the form if confirmed
                        }
                    });
                });
            });
        });
    </script>
    
    <!-- Google Translate Script -->
    <script>
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'id', 
                includedLanguages: 'id,en', 
                layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
                autoDisplay: false
            }, 'google_translate_element_admin');
        }

        function changeCustomLanguageAdmin(lang) {
            let select = document.querySelector('.goog-te-combo');
            if (select) {
                select.value = lang;
                select.dispatchEvent(new Event('change', { bubbles: true, cancelable: true }));
            } else {
                document.cookie = `googtrans=/id/${lang}; path=/;`;
                window.location.reload();
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            let currentLang = 'id';
            const match = document.cookie.match(/googtrans=\/id\/([a-z]{2})/);
            if (match) currentLang = match[1];

            document.querySelectorAll('.admin-custom-lang').forEach(selector => {
                selector.value = currentLang;
                selector.addEventListener('change', function() {
                    changeCustomLanguageAdmin(this.value);
                });
            });
        });
    </script>
    <script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

    @stack('scripts')
</body>
</html>
