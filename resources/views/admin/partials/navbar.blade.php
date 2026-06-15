<header class="admin-topbar">
    <div class="topbar-left">
        <button id="menu-toggle" class="menu-toggle">
            <i data-feather="menu"></i>
        </button>
    </div>
    
    <div class="topbar-right">
        <!-- Ke Halaman Utama -->
        <a href="{{ route('home') }}" class="btn btn-secondary" style="font-size: 0.85rem; padding: 0.4rem 0.8rem;">
            <i data-feather="globe" style="width: 14px; height: 14px;"></i> <span class="topbar-btn-text">Lihat Web</span>
        </a>
        
        <!-- Google Translate Hidden Engine -->
        <div id="google_translate_element_admin"></div>
        
        <!-- Custom Language Switcher for Admin -->
        <select class="admin-custom-lang" style="margin-right: 10px;">
            <option value="id">ID</option>
            <option value="en">EN</option>
        </select>

        <!-- Theme Toggle for Admin -->
        <button id="admin-theme-toggle" style="background: none; border: none; cursor: pointer; color: var(--text-muted); display: flex; align-items: center; justify-content: center; padding: 6px; border-radius: 6px; transition: var(--transition-fast); margin-right: 15px;">
            <i data-feather="moon" id="admin-theme-icon" style="width: 18px; height: 18px;"></i>
        </button>
        
        <!-- Profile Dropdown (Simplified for now) -->
        <div class="user-profile">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Admin') }}&background=4F46E5&color=fff" alt="User Avatar">
            <span>{{ Auth::user()->name ?? 'Admin' }}</span>
        </div>
        
        <!-- Logout -->
        <a href="{{ route('logout') }}" class="btn-logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i data-feather="log-out"></i>
            <span>Logout</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const themeToggle = document.getElementById('admin-theme-toggle');
        const themeIcon = document.getElementById('admin-theme-icon');
        
        function updateIcon() {
            if (document.documentElement.classList.contains('dark')) {
                themeIcon.setAttribute('data-feather', 'sun');
                themeToggle.style.color = '#F59E0B'; // Amber
            } else {
                themeIcon.setAttribute('data-feather', 'moon');
                themeToggle.style.color = 'var(--text-muted)';
            }
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        }
        
        // Initial setup
        updateIcon();
        
        if (themeToggle) {
            themeToggle.addEventListener('click', () => {
                const isDark = document.documentElement.classList.contains('dark');
                if (isDark) {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('theme', 'light');
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('theme', 'dark');
                }
                updateIcon();
            });
        }
    });
</script>
