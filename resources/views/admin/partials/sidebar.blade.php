<aside class="admin-sidebar">
    <div class="sidebar-header">
        <img src="{{ asset('images/logo_TPL.png') }}" alt="Logo" class="logo">
        <h2>Portal TPL SVIPB</h2>
    </div>
    
    <nav class="sidebar-nav">
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i data-feather="grid"></i>
            <span>Dashboard</span>
        </a>
        <a href="{{ route('karya.index') }}" class="{{ request()->routeIs('karya.*') && !request()->routeIs('karya.validasi') ? 'active' : '' }}">
            <i data-feather="folder"></i>
            <span>Kelola Karya</span>
        </a>
        <a href="{{ route('activity-logs.index') }}" class="{{ request()->routeIs('activity-logs.*') ? 'active' : '' }}">
            <i data-feather="clock"></i>
            <span>Jejak Audit</span>
        </a>
        <a href="{{ route('info-prodi.index') }}" class="{{ request()->routeIs('info-prodi.*') ? 'active' : '' }}">
            <i data-feather="info"></i>
            <span>Info Prodi</span>
        </a>
        <a href="{{ route('karya.validasi') }}" class="{{ request()->routeIs('karya.validasi') ? 'active' : '' }}">
            <i data-feather="check-circle"></i>
            <span>Validasi Konten</span>
        </a>
        <a href="{{ route('dosen.index') }}" class="{{ request()->routeIs('dosen.*') ? 'active' : '' }}">
            <i data-feather="users"></i>
            <span>Dosen</span>
        </a>
        <a href="{{ route('admin.berita.index') }}" class="{{ request()->routeIs('admin.berita.*') ? 'active' : '' }}">
            <i data-feather="file-text"></i>
            <span>Berita</span>
        </a>
        <a href="{{ route('admin.matakuliah.index') }}" class="{{ request()->routeIs('admin.matakuliah.*') ? 'active' : '' }}">
            <i data-feather="book-open"></i>
            <span>Mata Kuliah</span>
        </a>
        <a href="{{ route('admin.review.index') }}" class="{{ request()->routeIs('admin.review.*') ? 'active' : '' }}">
            <i data-feather="message-square"></i>
            <span>Kelola Review</span>
        </a>
        
        @if (Auth::check() && Auth::user()->role == 'admin')
        <a href="{{ route('admin.list') }}" class="{{ request()->routeIs('admin.list') ? 'active' : '' }}">
            <i data-feather="shield"></i>
            <span>Kelola Admin</span>
        </a>
        @endif
    </nav>
</aside>
