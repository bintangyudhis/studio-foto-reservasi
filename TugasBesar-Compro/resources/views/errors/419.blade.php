<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>419 — Sesi Berakhir | Sejenak Studio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;1,400&family=Manrope:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root { --ink:#137887; --paper:#fffaf0; --accent:#f7a900; --muted:#5d7d82; }
        body { background:var(--paper); font-family:'Manrope',sans-serif; min-height:100vh; display:flex; align-items:center; justify-content:center; }
        .error-code { font-family:'Playfair Display',serif; font-size:clamp(80px,18vw,160px); color:var(--ink); opacity:.12; line-height:1; font-weight:400; }
        .error-title { font-family:'Playfair Display',serif; font-size:clamp(22px,4vw,32px); color:var(--ink); margin-top:-20px; }
        .error-msg { color:var(--muted); font-weight:300; }
        .btn-home { background:var(--accent); color:#0d6472; font-weight:600; border:none; border-radius:999px; padding:12px 32px; text-decoration:none; display:inline-block; transition:transform .2s; margin:0 8px; }
        .btn-home:hover { transform:translateY(-2px); background:#ffc841; color:#0d6472; }
        .btn-back { background:transparent; color:var(--ink); border:1.5px solid var(--ink); border-radius:999px; padding:11px 28px; text-decoration:none; display:inline-block; transition:transform .2s; margin:0 8px; }
        .btn-back:hover { transform:translateY(-2px); }
    </style>
</head>
<body>
<div class="text-center px-3">
    <svg style="opacity:.15" class="mb-2" width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="#137887" stroke-width="1.2">
        <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
    </svg>
    <div class="error-code">419</div>
    <h1 class="error-title">Sesi Kamu Sudah Berakhir</h1>
    <p class="error-msg mt-2 mb-4">Halaman ini sudah terlalu lama terbuka dan token keamanannya kadaluarsa.<br>Silakan refresh halaman dan coba lagi. ⏱️</p>
    <a href="javascript:history.back()" class="btn-back">← Kembali</a>
    <a href="{{ url('/') }}" class="btn-home">Beranda</a>
</div>
</body>
</html>
