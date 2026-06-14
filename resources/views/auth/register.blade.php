<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar | Portal Karya Teknologi RPL - SV IPB</title>
  
  {{-- Favicon TPL --}}
  <link rel="icon" type="image/png" href="{{ asset('images/logo_TPL.png') }}">
  
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/admin/login.css') }}">
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

        @if(session('success'))
          <div class="modern-alert alert-success">
            <svg class="alert-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span>{{ session('success') }}</span>
          </div>
        @endif

        @if(session('error'))
          <div class="modern-alert alert-error">
            <svg class="alert-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span>{{ session('error') }}</span>
          </div>
        @endif

        @if($errors->any())
          <div class="modern-alert alert-error">
            <svg class="alert-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <ul style="margin: 0; padding-left: 1rem; text-align: left; font-size: 0.85rem; list-style-type: disc;">
              @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <h2>Daftar</h2>
        <p>Daftar untuk dapat mengeksplorasi karya!</p>
        
        <form action="{{ route('register') }}" method="POST">
          @csrf
          @method("POST")

          <div class="input-wrapper animate-stagger-3">
            <label for="name">Nama</label>
            <input type="text" id="name" name="name" placeholder="Masukkan nama" required>
          </div>

          <div class="input-wrapper animate-stagger-4">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Masukkan email" required>
          </div>

          <div class="input-wrapper animate-stagger-5">
            <label for="password">Buat kata sandi</label>
            <div class="input-group">
              <input type="password" id="password" name="password" placeholder="Buat kata sandi" required>
              <button type="button" class="toggle-password" onclick="togglePassword('password', 'eye-icon-show-1', 'eye-icon-hide-1')" tabindex="-1">
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

          <div class="input-wrapper animate-stagger-6">
            <label for="password_confirmation">Konfirmasi Kata Sandi</label>
            <div class="input-group">
              <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Konfirmasi kata sandi" required>
              <button type="button" class="toggle-password" onclick="togglePassword('password_confirmation', 'eye-icon-show-2', 'eye-icon-hide-2')" tabindex="-1">
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

          <button class="login-btn animate-stagger-6" type="submit">Daftar</button>

          <div class="links animate-stagger-6">
            <p>Sudah punya akun? <a href="{{ route('login') }}" class="signup">Masuk</a></p>
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
</body>

</html>