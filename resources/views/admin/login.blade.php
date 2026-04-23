<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — Funny Bingo</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', system-ui, sans-serif; background: #0f172a; color: #f1f5f9; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .login-box { background: #1e293b; border: 1px solid #334155; border-radius: 16px; padding: 40px; width: 100%; max-width: 380px; }
        .login-box h1 { font-size: 1.4rem; font-weight: 900; color: #fbbf24; margin-bottom: 6px; }
        .login-box p { font-size: 0.85rem; color: #64748b; margin-bottom: 28px; }
        label { display: block; font-size: 0.78rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: .04em; margin-bottom: 6px; }
        input[type=password] { width: 100%; background: #0f172a; border: 1px solid #334155; color: #f1f5f9; padding: 12px 14px; border-radius: 8px; font-size: 0.95rem; transition: border-color 0.15s; }
        input[type=password]:focus { outline: none; border-color: #16a34a; }
        .error { color: #f87171; font-size: 0.8rem; margin-top: 6px; }
        button { width: 100%; margin-top: 20px; background: #16a34a; color: #000; border: none; padding: 13px; border-radius: 8px; font-weight: 900; font-size: 1rem; cursor: pointer; }
        button:hover { opacity: 0.85; }
    </style>
</head>
<body>
    <div class="login-box">
        <h1>Admin Login</h1>
        <p>Funny Bingo management panel</p>

        <form method="POST" action="{{ route('admin.login') }}">
            @csrf
            <label for="password">Password</label>
            <input type="password" name="password" id="password" autofocus required>
            @error('password')
                <div class="error">{{ $message }}</div>
            @enderror
            <button type="submit">Sign In</button>
        </form>
    </div>
</body>
</html>
