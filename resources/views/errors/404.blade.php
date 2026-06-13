<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Tidak Ditemukan</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4f46e5;
            --secondary: #ec4899;
            --bg-color: #0f172a;
        }
        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', -apple-system, sans-serif;
            background-color: var(--bg-color);
            background-image: 
                radial-gradient(circle at 15% 50%, rgba(79, 70, 229, 0.4), transparent 50%),
                radial-gradient(circle at 85% 30%, rgba(236, 72, 153, 0.4), transparent 50%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            color: #fff;
        }
        .glass-container {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 24px;
            padding: 4rem;
            text-align: center;
            max-width: 500px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            animation: float 6s ease-in-out infinite;
            position: relative;
            z-index: 10;
        }
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }
        h1 {
            font-size: 8rem;
            margin: 0;
            background: linear-gradient(to right, #a855f7, #ec4899);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 800;
        }
        p {
            font-size: 1.15rem;
            color: #cbd5e1;
            margin-bottom: 2.5rem;
            line-height: 1.6;
        }
        .btn {
            display: inline-block;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            text-decoration: none;
            padding: 1rem 2.5rem;
            border-radius: 9999px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 10px 15px -3px rgba(236, 72, 153, 0.3);
        }
        .btn:hover {
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 20px 25px -5px rgba(236, 72, 153, 0.5);
        }
        .blob {
            position: absolute;
            width: 400px;
            height: 400px;
            background: linear-gradient(180deg, rgba(79, 70, 229, 0.4) 0%, rgba(236, 72, 153, 0.4) 100%);
            filter: blur(100px);
            border-radius: 50%;
            z-index: 1;
            animation: pulse 8s ease-in-out infinite;
        }
        @keyframes pulse {
            0% { transform: scale(1) translate(0, 0); }
            33% { transform: scale(1.2) translate(50px, -50px); }
            66% { transform: scale(0.8) translate(-50px, 50px); }
            100% { transform: scale(1) translate(0, 0); }
        }
    </style>
</head>
<body>
    <div class="blob"></div>
    <div class="glass-container">
        <h1>404</h1>
        <p>Oops! Sepertinya Anda tersesat di ruang hampa. Halaman yang Anda cari tidak dapat ditemukan.</p>
        <a href="{{ url('/') }}" class="btn">Kembali ke Beranda</a>
    </div>
</body>
</html>
