<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Portal Karya Teknologi RPL - SV IPB</title>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/admin/login.css') }}">
  <style>
    .alert-success {
      background: #d4f8d4;
      color: #136b13;
      padding: 10px;
      border-radius: 6px;
      margin-bottom: 10px;
    }

    .alert-error {
      background: #ffd3d3;
      color: #9e1c1c;
      padding: 10px;
      border-radius: 6px;
      margin-bottom: 10px;
    }
  </style>
</head>

<script>
  function togglePassword() {
    const pass = document.getElementById("password");
    const icon = document.getElementById("eyeIcon");

    if (pass.type === "password") {
      pass.type = "text";
      icon.src = "https://cdn-icons-png.flaticon.com/512/159/159078.png"; // ikon mata tertutup
    } else {
      pass.type = "password";
      icon.src = "https://cdn-icons-png.flaticon.com/512/709/709612.png"; // ikon mata terbuka
    }
  }
</script>

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

        @if(session('success'))
          <div class="alert-success">
            {{ session('success') }}
          </div>
        @endif

        @if(session('error'))
          <div class="alert-error">
            {{ session('error') }}
          </div>
        @endif

        <h2>Masuk</h2>
        <p>Masuk untuk dapat mengeksplore karya!</p>
        <form action="{{ route('login.submit') }}" method="POST">
          @csrf
          @method("POST")
          <label for="email">Email</label>
          <input type="email" id="email" name="email" placeholder="Masukkan email" required>

          <label for="password">Kata Sandi</label>
          <div class="input-group">
            <input type="password" id="password" name="password" placeholder="Masukkan kata sandi" required>
            <span class="toggle-password" onclick="togglePassword()">
              <img src="https://cdn-icons-png.flaticon.com/512/709/709612.png" id="eyeIcon">
            </span>
          </div>


          <button class="login-btn" type="submit">Masuk</button>

          <div class="links">
            <p>Belum punya akun? <a href="{{ route('register') }}" class="signup">Daftar</a></p>
            <a href="{{ route('forgot-password') }}" class="forgot">Lupa kata sandi?</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>

</html>