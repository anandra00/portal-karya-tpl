<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Atur Ulang Kata Sandi | Portal Karya Teknologi RPL - SV IPB</title>
  
  {{-- Favicon TPL --}}
  <link rel="icon" type="image/png" href="{{ asset('images/logo_TPL.png') }}">
  
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/admin/login.css') }}">

  {{-- Dark Mode Init (Prevent Flash) --}}
  <script>
      if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
          document.documentElement.classList.add('dark');
      } else {
          document.documentElement.classList.remove('dark');
      }
  </script>
</head>
<body>
  <!-- Animated Background Orbs -->
  <div class="orb orb-1"></div>
  <div class="orb orb-2"></div>
  <div class="orb orb-3"></div>

  <div class="login-container animate-fade-in-up">

    <div class="left-panel">
      <div class="logos">
      </div>
      <div class="welcome-text animate-stagger-1">
        <h1>Selamat datang di...</h1>
        <h2>Portal Karya Teknologi Rekayasa Perangkat Lunak</h2>
        <p>Sekolah Vokasi IPB University</p>
      </div>
    </div>

    <div class="right-panel">
      <div class="login-box animate-stagger-2">
        <h2>Atur Ulang Kata Sandi</h2>
        <p>Masukkan kata sandi baru Anda dan konfirmasikan untuk memperbarui.</p>
        
        <form action="{{ route('reset-password.submit', $token) }}" method="POST">
          @csrf
          @method('post')

          {{-- WAJIB ADA: Input Hidden Token --}}
          <input type="hidden" name="token" value="{{ $token }}">

          <div class="input-wrapper animate-stagger-3">
            <label for="password">Kata Sandi Baru</label>
            <div class="input-group">
              <input type="password" id="password" name="password" placeholder="Masukkan kata sandi baru" required>
              <button type="button" class="toggle-password" onclick="togglePassword('password', 'eye-icon-show-1', 'eye-icon-hide-1')" tabindex="-1" aria-label="Toggle password visibility">
                <svg id="eye-icon-show-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: block;">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                <svg id="eye-icon-hide-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 011.533-3.033m3.03-3.03A9.922 9.922 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.02 10.02 0 01-1.534 3.033m-3.03 3.03l-7.394-7.394m11.238 11.238l-7.394-7.394m11.238 11.238L3 3" />
                </svg>
              </button>
            </div>
          </div>

          <div class="input-wrapper animate-stagger-4">
            <label for="password_confirmation">Konfirmasi Kata Sandi Baru</label>
            <div class="input-group">
              <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi kata sandi baru" required>
              <button type="button" class="toggle-password" onclick="togglePassword('password_confirmation', 'eye-icon-show-2', 'eye-icon-hide-2')" tabindex="-1" aria-label="Toggle password visibility">
                <svg id="eye-icon-show-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: block;">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                <svg id="eye-icon-hide-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 011.533-3.033m3.03-3.03A9.922 9.922 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.02 10.02 0 01-1.534 3.033m-3.03 3.03l-7.394-7.394m11.238 11.238l-7.394-7.394m11.238 11.238L3 3" />
                </svg>
              </button>
            </div>
          </div>

          <button class="login-btn animate-stagger-5" type="submit">Perbarui Kata Sandi</button>

          <div class="links animate-stagger-6">
            <p>Batal ganti password? <a href="{{ route('login') }}" class="signup">Masuk</a></p>
          </div>

        </form>
      </div>
    </div>
  </div>

  <script>
    function togglePassword(inputId, showIconId, hideIconId) {
      const pass = document.getElementById(inputId);
      const iconShow = document.getElementById(showIconId);
      const iconHide = document.getElementById(hideIconId);

      if (pass.type === "password") {
        pass.type = "text";
        iconShow.style.display = "none";
        iconHide.style.display = "block";
      } else {
        pass.type = "password";
        iconShow.style.display = "block";
        iconHide.style.display = "none";
      }
    }
  </script>

  {{-- Script Notifikasi Error --}}
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  @if(session('error'))
  <script>
      Swal.fire({
          icon: 'error',
          title: 'Gagal',
          text: '{{ session("error") }}',
          confirmButtonColor: '#4F46E5',
          background: 'rgba(255, 255, 255, 0.95)',
          backdrop: `rgba(0,0,0,0.4)`
      });
  </script>
  @endif

  @if($errors->any())
  <script>
      Swal.fire({
          icon: 'error',
          title: 'Validasi Gagal',
          html: `<ul style="text-align: left; margin: 0; padding-left: 1rem; font-size: 0.9rem;">
              @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>`,
          confirmButtonColor: '#4F46E5',
          background: 'rgba(255, 255, 255, 0.95)',
          backdrop: `rgba(0,0,0,0.4)`
      });
  </script>
  @endif
</body>
</html>