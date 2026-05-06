<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Sejenak Studio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;1,400&family=Manrope:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --ink: #137887;
            --ink-deep: #0d6472;
            --paper: #fffaf0;
            --accent: #f7a900;
            --accent-soft: #ffc841;
            --line: rgba(19, 120, 135, .18);
            --radius-lg: 24px;
            --radius-pill: 999px;
            --serif: "Playfair Display", serif;
            --sans: "Manrope", sans-serif;
        }

        * { box-sizing: border-box; }
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            background:
                radial-gradient(circle at 16% 84%, rgba(247,169,0,.92) 0 15%, transparent 15.5%),
                radial-gradient(circle at 88% 14%, rgba(247,169,0,.28) 0 12%, transparent 12.5%),
                var(--ink);
            color: var(--ink-deep);
            font-family: var(--sans);
        }

        .login-card {
            width: min(100%, 430px);
            padding: clamp(28px, 5vw, 44px);
            border: 1px solid rgba(255,255,255,.76);
            border-radius: var(--radius-lg);
            background: rgba(255,250,240,.96);
            box-shadow: 0 28px 80px rgba(0,0,0,.16);
        }

        .brand {
            color: var(--ink);
            font-family: var(--serif);
            font-size: 38px;
            font-style: italic;
            line-height: 1;
            margin-bottom: 6px;
        }

        .brand span {
            display: block;
            color: var(--accent);
            font-family: var(--sans);
            font-size: 11px;
            font-style: normal;
            font-weight: 700;
            letter-spacing: .18em;
            margin-top: 7px;
            text-transform: uppercase;
        }

        .form-label {
            color: var(--ink);
            font-size: 12px;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
        }

        .form-control {
            min-height: 46px;
            border: 1px solid var(--line);
            border-radius: 14px;
            color: var(--ink-deep);
        }

        .form-control:focus {
            border-color: var(--ink);
            box-shadow: 0 0 0 .16rem rgba(19,120,135,.12);
        }

        .btn-primary {
            min-height: 46px;
            border: 0;
            border-radius: var(--radius-pill);
            background: var(--accent);
            color: var(--ink-deep);
            font-size: 12px;
            font-weight: 800;
            letter-spacing: .12em;
            text-transform: uppercase;
        }

        .btn-primary:hover {
            background: var(--accent-soft);
            color: var(--ink-deep);
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="text-center mb-4">
            <div class="brand">Sejenak <span>Admin Panel</span></div>
            <p class="text-muted small mb-0">Masuk untuk mengelola reservasi, paket, galeri, dan chatbot.</p>
        </div>

        @if($errors->any())
            <div class="alert alert-danger small">{{ $errors->first() }}</div>
        @endif

        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control" placeholder="admin@sejenak.com" required autofocus>
            </div>
            <div class="mb-4">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Sign In</button>
        </form>
    </div>
</body>
</html>
