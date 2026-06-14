<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Portal Karya Teknologi RPL - SV IPB</title>
  
  {{-- Favicon TPL --}}
  <link rel="icon" type="image/png" href="{{ asset('images/logo_TPL.png') }}">
  
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
   <link rel="stylesheet" href="{{ asset('css/admin/login.css') }}">
</head>
<body>
  <div class="login-container">

    <div class="left-panel">
      <div class="logos"></div>
      <div class="welcome-text">
        <h1>Selamat datang di...</h1>
        <h2>Portal Karya Teknologi Rekayasa Perangkat Lunak</h2>
        <p>Sekolah Vokasi IPB University</p>
      </div>
    </div>

    <div class="right-panel">
      <div class="login-box">
        <h2>Atur Ulang Kata Sandi</h2>
        <p>Masukkan password baru dan konfirmasi password baru</p>
        
        {{-- Pastikan route ini sesuai --}}
        <form action="{{ route('reset-password.submit', $token) }}" method="POST">
          @csrf
          @method('post')

          {{-- WAJIB ADA: Input Hidden Token --}}
          <input type="hidden" name="token" value="{{ $token }}">

          <div class="mb-3">
              <label for="password">Password Baru</label>
              <input type="password" id="password" name="password" placeholder="Masukkan password baru" required>
          </div>

          <div class="mb-3">
              <label for="password-confirmation">Konfirmasi Password</label>
              <input type="password" id="password-confirmation" name="password_confirmation" placeholder="Ulangi password baru" required>
          </div>

          <button class="login-btn" type="submit">Perbarui Kata Sandi</button>

          <div class="links" style="margin-top: 15px; text-align: center;">
            <p>Batal ganti password? <a href="{{ route('login') }}" style="color: #263C92; font-weight: 600; text-decoration: none;">Masuk</a></p>
          </div>

        </form>
      </div>
    </div>
  </div>

  {{-- Script Notifikasi Error --}}
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  @if(session('error'))
  <script>
      Swal.fire({
          icon: 'error',
          title: 'Gagal',
          text: '{{ session("error") }}',
          confirmButtonColor: '#263C92'
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
          confirmButtonColor: '#263C92'
      });
  </script>
  @endif
</body>
</html>