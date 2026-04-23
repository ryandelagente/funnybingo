<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — Funny Bingo</title>

    {{-- Google Analytics GA4 (admin traffic) --}}
    @if(config('app.google_analytics_id'))
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('app.google_analytics_id') }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '{{ config('app.google_analytics_id') }}', {
            'custom_map': {'dimension1': 'admin_user'}
        });
        gtag('set', {'dimension1': 'admin'});
    </script>
    @endif

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', system-ui, sans-serif;
            background: #0f172a;
            color: #f1f5f9;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Top bar */
        .admin-bar {
            background: #020617;
            border-bottom: 1px solid #1e293b;
            padding: 0 24px;
            height: 56px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .admin-bar .brand { font-weight: 900; color: #16a34a; font-size: 1rem; letter-spacing: 1px; text-decoration: none; }
        .admin-bar nav { display: flex; gap: 6px; }
        .admin-bar nav a, .admin-bar nav button {
            color: #94a3b8; text-decoration: none; font-size: 0.8rem; font-weight: 700;
            padding: 6px 14px; border-radius: 6px; border: none; background: none; cursor: pointer;
            transition: background 0.15s, color 0.15s;
        }
        .admin-bar nav a:hover, .admin-bar nav button:hover { background: #1e293b; color: #f1f5f9; }
        .admin-bar nav a.active { background: #1e293b; color: #fbbf24; }

        /* Main layout */
        .admin-main { flex: 1; padding: 32px 24px; max-width: 1200px; width: 100%; margin: 0 auto; }

        /* Page header */
        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
        .page-header h1 { font-size: 1.5rem; font-weight: 900; color: #fbbf24; }

        /* Alerts */
        .alert { padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-weight: 600; font-size: 0.875rem; }
        .alert-success { background: #14532d; color: #86efac; border: 1px solid #166534; }
        .alert-error { background: #450a0a; color: #fca5a5; border: 1px solid #7f1d1d; }

        /* Buttons */
        .btn { display: inline-flex; align-items: center; gap: 6px; padding: 9px 18px; border-radius: 8px; font-weight: 700; font-size: 0.875rem; border: none; cursor: pointer; text-decoration: none; transition: opacity 0.15s; }
        .btn:hover { opacity: 0.85; }
        .btn-primary { background: #16a34a; color: #000; }
        .btn-warning { background: #d97706; color: #000; }
        .btn-danger  { background: #dc2626; color: #fff; }
        .btn-ghost   { background: #1e293b; color: #94a3b8; }
        .btn-sm { padding: 5px 12px; font-size: 0.78rem; }

        /* Table */
        .table-wrap { background: #1e293b; border-radius: 12px; border: 1px solid #334155; overflow: hidden; }
        table { width: 100%; border-collapse: collapse; }
        thead { background: #0f172a; }
        th { padding: 12px 16px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: .05em; }
        td { padding: 12px 16px; border-top: 1px solid #334155; font-size: 0.875rem; vertical-align: middle; }
        tr:hover td { background: #253347; }
        .badge { display: inline-block; padding: 2px 8px; border-radius: 4px; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; background: #334155; color: #94a3b8; }
        .badge-green { background: #14532d; color: #86efac; }

        /* Form */
        .card { background: #1e293b; border: 1px solid #334155; border-radius: 12px; padding: 28px; }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .form-group { display: flex; flex-direction: column; gap: 6px; }
        .form-group.full { grid-column: 1 / -1; }
        label { font-size: 0.8rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: .04em; }
        input[type=text], input[type=datetime-local], select, textarea {
            background: #0f172a; border: 1px solid #334155; color: #f1f5f9;
            padding: 10px 14px; border-radius: 8px; font-size: 0.9rem; font-family: inherit;
            width: 100%; transition: border-color 0.15s;
        }
        input[type=text]:focus, input[type=datetime-local]:focus, select:focus, textarea:focus {
            outline: none; border-color: #16a34a;
        }
        textarea { resize: vertical; }
        .field-hint { font-size: 0.75rem; color: #475569; }
        .error-msg { font-size: 0.78rem; color: #f87171; margin-top: 2px; }
        .form-actions { display: flex; gap: 10px; margin-top: 24px; }

        /* Stats */
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 16px; margin-bottom: 28px; }
        .stat-card { background: #1e293b; border: 1px solid #334155; border-radius: 10px; padding: 20px; }
        .stat-card .num { font-size: 2rem; font-weight: 900; color: #fbbf24; }
        .stat-card .lbl { font-size: 0.75rem; color: #64748b; text-transform: uppercase; font-weight: 700; margin-top: 4px; }

        @media (max-width: 640px) {
            .form-grid { grid-template-columns: 1fr; }
            .admin-bar nav a span { display: none; }
        }
    </style>
    @stack('styles')
</head>
<body>

<header class="admin-bar">
    <a href="{{ route('admin.posts.index') }}" class="brand">⚙ Funny Bingo Admin</a>
    <nav>
        <a href="{{ route('admin.posts.index') }}" class="{{ request()->routeIs('admin.posts*') ? 'active' : '' }}">Posts</a>
        <a href="{{ route('admin.posts.create') }}">+ New Post</a>
        <a href="{{ route('admin.settings') }}" class="{{ request()->routeIs('admin.settings') ? 'active' : '' }}">Settings</a>
        <a href="{{ route('bingo.index') }}" target="_blank">View Site</a>
        <form method="POST" action="{{ route('admin.logout') }}" style="display:inline;">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </nav>
</header>

<main class="admin-main">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->any() && !$errors->has('password'))
        <div class="alert alert-error">Please fix the errors below.</div>
    @endif

    @yield('content')
</main>

</body>
</html>
