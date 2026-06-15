<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 — Akses Ditolak | Sejenak Studio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;1,400&family=Manrope:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root { --ink:#137887; --paper:#fffaf0; --accent:#f7a900; --muted:#5d7d82; }
        body { background:var(--paper); font-family:'Manrope',sans-serif; min-height:100vh; display:flex; align-items:center; justify-content:center; }
        .error-code { font-family:'Playfair Display',serif; font-size:clamp(80px,18vw,160px); color:var(--ink); opacity:.12; line-height:1; font-weight:400; }
        .error-title { font-family:'Playfair Display',serif; font-size:clamp(22px,4vw,32px); color:var(--ink); margin-top:-20px; }
        .error-msg { color:var(--muted); font-weight:300; }
        .btn-home { background:var(--accent); color:#0d6472; font-weight:600; border:none; border-radius:999px; padding:12px 32px; text-decoration:none; display:inline-block; transition:transform .2s; }
        .btn-home:hover { transform:translateY(-2px); background:#ffc841; color:#0d6472; }
    </style>
</head>
<body>
<div class="text-center px-3">
    <svg style="opacity:.15" class="mb-2" width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="#137887" stroke-width="1.2">
        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
        <path d="M7 11V7a5 5 0 0110 0v4"/>
    </svg>
    <div class="error-code">403</div>
    <h1 class="error-title">Akses Tidak Diizinkan</h1>
    <p class="error-msg mt-2 mb-4">Kamu tidak memiliki izin untuk mengakses halaman ini.<br>Kalau kamu merasa ini kesalahan, silakan hubungi admin. 🔒</p>
    <a href="{{ url('/') }}" class="btn-home">← Kembali ke Beranda</a>
</div>
</body>
</html>
