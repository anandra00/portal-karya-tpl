<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - Kesalahan Server</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #ef4444;
            --secondary: #f97316;
            --bg-color: #171717;
        }
        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', -apple-system, sans-serif;
            background-color: var(--bg-color);
            background-image: 
                radial-gradient(circle at 20% 80%, rgba(239, 68, 68, 0.3), transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(249, 115, 22, 0.3), transparent 50%);
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
            animation: shake 10s ease-in-out infinite;
            position: relative;
            z-index: 10;
        }
        @keyframes shake {
            0%, 100% { transform: rotate(0deg); }
            25% { transform: rotate(1deg) translateY(-5px); }
            75% { transform: rotate(-1deg) translateY(5px); }
        }
        h1 {
            font-size: 8rem;
            margin: 0;
            background: linear-gradient(to right, #ef4444, #f97316);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 800;
        }
        p {
            font-size: 1.15rem;
            color: #d4d4d8;
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
            box-shadow: 0 10px 15px -3px rgba(239, 68, 68, 0.3);
        }
        .btn:hover {
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 20px 25px -5px rgba(239, 68, 68, 0.5);
        }
        .blob {
            position: absolute;
            width: 400px;
            height: 400px;
            background: linear-gradient(180deg, rgba(239, 68, 68, 0.3) 0%, rgba(249, 115, 22, 0.3) 100%);
            filter: blur(100px);
            border-radius: 50%;
            z-index: 1;
            animation: pulse 6s ease-in-out infinite alternate;
        }
        @keyframes pulse {
            0% { transform: scale(1); opacity: 0.8; }
            100% { transform: scale(1.1); opacity: 1; }
        }
    </style>
</head>
<body>
    <div class="blob"></div>
    <div class="glass-container">
        <h1>500</h1>
        <p>Aduh! Terjadi kesalahan pada server kami. Tim mekanik sedang berusaha memperbaikinya secepat mungkin.</p>
        <a href="{{ url('/') }}" class="btn">Kembali ke Beranda</a>
    </div>
</body>
</html>
