<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 — Terjadi Kesalahan | Sejenak Studio</title>
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
        <path d="M23 19a2 2 0 01-2 2H3a2 2 0 01-2-2V8a2 2 0 012-2h4l2-3h6l2 3h4a2 2 0 012 2z"/>
        <circle cx="12" cy="13" r="4"/>
        <line x1="12" y1="11" x2="12" y2="13"/><line x1="12" y1="15" x2="12.01" y2="15"/>
    </svg>
    <div class="error-code">500</div>
    <h1 class="error-title">Terjadi Kesalahan di Server</h1>
    <p class="error-msg mt-2 mb-4">Server kami sedang tidak enak badan. Tim kami sudah diberitahu<br>dan sedang memperbaikinya. Coba lagi dalam beberapa saat. 🙏</p>
    <a href="{{ url('/') }}" class="btn-home">← Kembali ke Beranda</a>
</div>
</body>
</html>
