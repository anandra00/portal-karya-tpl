<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Portal Karya Teknologi RPL - SV IPB</title>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
   <link rel="stylesheet" href="{{ asset('css/admin/login.css') }}">
</head>
<body>
  <div class="login-container">

    <div class="left-panel">
      <div class="logos">
      </div>
      <div class="welcome-text">
        <h1>Selamat datang di...</h1>
        <h2>Portal Karya Teknologi Rekayasa Perangkat Lunak</h2>
        <p>Sekolah Vokasi IPB University</p>
      </div>
    </div>

    <div class="right-panel">
      <div class="login-box">
        <h2>Atur Ulang Kata Sandi</h2>
        <p>Masukkan alamat email terdaftar. Tautan akan terkirim untuk mengatur ulang kata sandi.</p>
        
        <form action="{{ route('forgot-password.submit') }}" method="POST">
          @csrf
          @method('post')
          <label for="email">Email</label>
          <input type="email" id="email" name="email" placeholder="Masukkan email" required>

          <button class="login-btn" type="submit"> Kirim Tautan</button>

          {{-- Link Kembali ke Login --}}
          <div class="links" style="margin-top: 20px; text-align: center;">
            <a href="{{ route('login') }}" style="color: #4F46E5; font-weight: 600; text-decoration: none;">
                Kembali ke halaman login
            </a>
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
          timer: 2000
      });
  </script>
  @endif
</body>
</html>