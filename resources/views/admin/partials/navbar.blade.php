<header class="admin-topbar">
    <div class="topbar-left">
        <button id="menu-toggle" class="menu-toggle">
            <i data-feather="menu"></i>
        </button>
    </div>
    
    <div class="topbar-right">
        <!-- Ke Halaman Utama -->
        <a href="{{ route('home') }}" class="btn btn-secondary" style="font-size: 0.85rem; padding: 0.4rem 0.8rem;">
            <i data-feather="globe" style="width: 14px; height: 14px;"></i> Lihat Web
        </a>
        
        <!-- Google Translate Hidden Engine -->
        <div id="google_translate_element_admin"></div>
        
        <!-- Custom Language Switcher for Admin -->
        <select class="admin-custom-lang" style="margin-right: 15px;">
            <option value="id">ID</option>
            <option value="en">EN</option>
        </select>
        
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
