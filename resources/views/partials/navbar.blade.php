<nav class="navbar navbar-expand-lg bg-body-tertiary shadow-sm fixed-top navbar-custom">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
            <img src="{{ asset('images/logotpl.png') }}" alt="Logo TPL" style="height: 50px;">

            <div class="ms-2 d-none d-sm-block" style="line-height: 1.1; font-size: 0.9rem;">
                <strong style="font-size: 1.1em; display: block; color: var(--warna-hero);">TPL SV IPB</strong>
                <small style="opacity: 0.8; display: block; font-weight: 500; color: var(--warna-utama);">Teknologi Rekayasa Perangkat Lunak</small>
            </div>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-lg-center">

                <li class="nav-item">
                    <a class="nav-link nav-tpl-link {{ request()->routeIs('home') ? 'active' : '' }}"
                       href="{{ route('home') }}">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link nav-tpl-link {{ request()->routeIs('tentang') ? 'active' : '' }}"
                       href="{{ route('tentang') }}">Tentang</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link nav-tpl-link {{ request()->routeIs('homepage.dosen') ? 'active' : '' }}"
                       href="{{ route('homepage.dosen') }}">Dosen</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link nav-tpl-link {{ request()->routeIs('matakuliah.user') ? 'active' : '' }}"
                       href="{{ route('matakuliah.user') }}">Mata Kuliah</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link nav-tpl-link {{ request()->routeIs('faq') ? 'active' : '' }}"
                       href="{{ route('faq') }}">FAQ</a>
                </li>

                {{-- UNTUK USER LOGIN --}}
                @auth
                    <li class="nav-item ms-lg-2">
                        @if(Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin')
                            <a class="nav-link nav-tpl-link fw-bold"
                               href="{{ route('dashboard') }}">
                                <i class="bi bi-person-circle me-1"></i>{{ Auth::user()->name }}
                            </a>
                        @else
                            <a class="nav-link nav-tpl-link fw-bold">
                                <i class="bi bi-person-circle me-1"></i>{{ Auth::user()->name }}
                            </a>
                        @endif
                    </li>

                    <li class="nav-item">
                        <a class="nav-link nav-tpl-link text-danger" href="{{ route('logout') }}">
                            <i class="bi bi-box-arrow-right me-1"></i>Logout
                        </a>
                    </li>

                @else
                    {{-- USER BELUM LOGIN --}}
                    <li class="nav-item ms-lg-3 mb-2 mb-lg-0">
                        <a class="btn btn-outline-primary w-100 {{ request()->routeIs('login') ? 'active' : '' }}"
                           href="{{ route('login') }}" style="border-radius: 8px; font-weight: 600;">Login</a>
                    </li>

                    <li class="nav-item ms-lg-3">
                        <a class="btn btn-tpl w-100 {{ request()->routeIs('register') ? 'active' : '' }}"
                           href="{{ route('register') }}" style="border-radius: 8px; font-weight: 600; padding: 0.375rem 1.25rem;">Register</a>
                    </li>
                @endauth

            </ul>
        </div>
    </div>
</nav>