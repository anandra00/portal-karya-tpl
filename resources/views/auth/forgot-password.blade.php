<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Atur Ulang Kata Sandi | Portal Karya Teknologi RPL - SV IPB</title>
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
        
        <h2>Atur Ulang Kata Sandi</h2>
        <p>Masukkan alamat email terdaftar. Tautan akan terkirim untuk mengatur ulang kata sandi.</p>
        
        <form action="{{ route('forgot-password.submit') }}" method="POST">
          @csrf
          @method('post')
          
          <div class="input-wrapper animate-stagger-3">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Masukkan email" required>
          </div>

          <button class="login-btn animate-stagger-4" type="submit">Kirim Tautan</button>

          {{-- Link Kembali ke Login --}}
          <div class="links animate-stagger-5" style="margin-top: 1.5rem;">
            <p><a href="{{ route('login') }}" class="signup">Kembali ke halaman login</a></p>
          </div>

        </form>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  @if(session('success'))
  <script>
      Swal.fire({
          icon: 'success',
          title: 'Berhasil!',
          text: '{{ session("success") }}',
          showConfirmButton: false,
          timer: 2000,
          background: 'rgba(255, 255, 255, 0.95)',
          backdrop: `rgba(0,0,0,0.4)`
      });
  </script>
  @endif
</body>
</html>