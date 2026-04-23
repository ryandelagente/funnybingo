<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Primary Meta --}}
    <title>{{ $meta_title ?? 'Funny Bingo - Free Online Bingo Caller & Card Generator' }}</title>
    <meta name="description" content="{{ $meta_description ?? 'Funny Bingo is a free, browser-based bingo caller with voice announcements, 15 patterns, QR player cards, and auto-call mode. Perfect for game nights, classrooms, and events.' }}">
    <meta name="keywords" content="funny bingo, bingo caller, bingo card generator, online bingo, bingo patterns, free bingo, bingo night, bingo philippines">
    <meta name="author" content="Ryan Jison de la Gente">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- Open Graph --}}
    <meta property="og:type" content="{{ $og_type ?? 'website' }}">
    <meta property="og:title" content="{{ $meta_title ?? 'Funny Bingo - Free Online Bingo Caller' }}">
    <meta property="og:description" content="{{ $meta_description ?? 'Free browser-based bingo caller with voice, patterns, and QR player cards.' }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="Funny Bingo">
    <meta property="og:image" content="{{ asset('images/og-image.svg') }}">
    <meta property="og:locale" content="en_US">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $meta_title ?? 'Funny Bingo - Free Online Bingo Caller' }}">
    <meta name="twitter:description" content="{{ $meta_description ?? 'Free browser-based bingo caller with voice, patterns, and QR player cards.' }}">
    <meta name="twitter:image" content="{{ asset('images/og-image.svg') }}">

    {{-- Google Search Console verification --}}
    @if(config('app.gsc_verification'))
    <meta name="google-site-verification" content="{{ config('app.gsc_verification') }}">
    @endif

    {{-- Google Analytics GA4 --}}
    @if(config('app.google_analytics_id'))
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('app.google_analytics_id') }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '{{ config('app.google_analytics_id') }}');
    </script>
    @endif

    {{-- Google AdSense --}}
    @if(config('app.adsense_client'))
    <meta name="google-adsense-account" content="{{ config('app.adsense_client') }}">
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client={{ config('app.adsense_client') }}"
            crossorigin="anonymous"></script>
    @endif

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    {{-- Styles --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        /* Layout extras for content pages */
        .site-header { background:#000; border-bottom:1px solid #1f2937; padding:12px 20px; display:flex; justify-content:space-between; align-items:center; position:sticky; top:0; z-index:1000; }
        .site-header .brand { font-weight:900; color:#16a34a; text-decoration:none; font-size:1.1rem; letter-spacing:1px; }
        .site-nav { display:flex; gap:20px; list-style:none; margin:0; padding:0; }
        .site-nav a { color:#94a3b8; text-decoration:none; font-weight:700; font-size:0.85rem; transition:color 0.2s; }
        .site-nav a:hover, .site-nav a.active { color:#fbbf24; }
        .nav-toggle { display:none; background:none; border:none; cursor:pointer; padding:6px; }
        .nav-toggle span { display:block; width:22px; height:2px; background:#94a3b8; margin:4px 0; border-radius:2px; transition:.3s; }
        @media(max-width:600px){
            .nav-toggle { display:block; }
            .site-nav { display:none; flex-direction:column; gap:0; position:absolute; top:49px; left:0; right:0; background:#000; border-bottom:1px solid #1f2937; padding:10px 0; z-index:999; }
            .site-nav.open { display:flex; }
            .site-nav li { width:100%; }
            .site-nav a { display:block; padding:12px 20px; font-size:0.9rem; }
        }
        .site-footer { background:#000; border-top:1px solid #1f2937; padding:30px 20px; text-align:center; color:#64748b; font-size:0.8rem; }
        .site-footer a { color:#94a3b8; text-decoration:none; margin:0 8px; }
        .site-footer a:hover { color:#fbbf24; }
        .content-wrap { max-width:860px; margin:0 auto; padding:40px 20px; color:#f8fafc; }
        .content-wrap h1 { font-size:2rem; font-weight:900; margin-bottom:10px; color:#fbbf24; }
        .content-wrap h2 { font-size:1.4rem; font-weight:800; margin:30px 0 10px; color:#16a34a; }
        .content-wrap h3 { font-size:1.1rem; font-weight:700; margin:20px 0 8px; color:#f8fafc; }
        .content-wrap p { line-height:1.8; color:#94a3b8; margin-bottom:15px; }
        .content-wrap ul, .content-wrap ol { color:#94a3b8; line-height:1.9; padding-left:20px; margin-bottom:15px; }
        .content-wrap a { color:#2563eb; }
        .post-meta { font-size:0.8rem; color:#64748b; margin-bottom:25px; display:flex; gap:15px; flex-wrap:wrap; align-items:center; }
        .post-meta .tag { background:#1f2937; border-radius:4px; padding:2px 8px; color:#94a3b8; text-transform:uppercase; font-size:0.7rem; font-weight:700; }
        .ad-slot { margin:30px 0; text-align:center; }
    </style>

    {{-- Sitewide: WebSite + Organization --}}
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@graph": [
        {
          "@type": "WebSite",
          "@id": "{{ url('/') }}/#website",
          "url": "{{ url('/') }}",
          "name": "Funny Bingo",
          "description": "Free online bingo caller with voice announcements, 15 patterns, QR player cards, and auto-call mode.",
          "publisher": { "@id": "{{ url('/') }}/#organization" },
          "potentialAction": {
            "@type": "SearchAction",
            "target": { "@type": "EntryPoint", "urlTemplate": "{{ route('blog.index') }}?category={search_term_string}" },
            "query-input": "required name=search_term_string"
          }
        },
        {
          "@type": "Organization",
          "@id": "{{ url('/') }}/#organization",
          "name": "Funny Bingo",
          "url": "{{ url('/') }}",
          "logo": {
            "@type": "ImageObject",
            "url": "{{ asset('images/og-image.svg') }}",
            "width": 1200,
            "height": 630
          },
          "sameAs": []
        }
      ]
    }
    </script>

    {{-- Per-page schema --}}
    @stack('schema')
</head>
<body style="background:#020617; color:#f8fafc; font-family:'Inter',system-ui,sans-serif; margin:0; min-height:100vh; display:flex; flex-direction:column;">

<header class="site-header" style="position:relative;">
    <a href="{{ route('bingo.index') }}" class="brand">Funny Bingo</a>
    <button class="nav-toggle" id="navToggle" aria-label="Toggle navigation">
        <span></span><span></span><span></span>
    </button>
    <nav>
        <ul class="site-nav" id="siteNav">
            <li><a href="{{ route('bingo.index') }}" {{ request()->is('/') ? 'class=active' : '' }}>PLAY</a></li>
            <li><a href="{{ route('blog.index') }}" {{ request()->is('blog*') ? 'class=active' : '' }}>BLOG</a></li>
            <li><a href="{{ route('page.about') }}" {{ request()->is('about') ? 'class=active' : '' }}>ABOUT</a></li>
            <li><a href="{{ route('page.contact') }}" {{ request()->is('contact') ? 'class=active' : '' }}>CONTACT</a></li>
        </ul>
    </nav>
    <script>
        document.getElementById('navToggle').addEventListener('click', function(){
            document.getElementById('siteNav').classList.toggle('open');
        });
    </script>
</header>

<main style="flex:1;">
    {{-- Top ad banner --}}
    @if(config('app.adsense_client'))
    <div style="text-align:center; padding:10px 0; background:#000; border-bottom:1px solid #1f2937;">
        <ins class="adsbygoogle"
             style="display:block"
             data-ad-client="{{ config('app.adsense_client') }}"
             data-ad-format="auto"
             data-full-width-responsive="true"></ins>
        <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
    </div>
    @endif

    @yield('content')
</main>

<footer class="site-footer">
    <p style="margin-bottom:10px;">
        <a href="{{ route('bingo.index') }}">Play Bingo</a>
        <a href="{{ route('blog.index') }}">Blog</a>
        <a href="{{ route('page.about') }}">About</a>
        <a href="{{ route('page.contact') }}">Contact</a>
        <a href="{{ route('page.privacy') }}">Privacy Policy</a>
        <a href="{{ route('page.terms') }}">Terms of Service</a>
    </p>
    <p>&copy; {{ date('Y') }} Ryan Jison de la Gente &mdash; Funny Bingo. All Rights Reserved.</p>
    <p style="margin-top:8px; font-size:0.7rem;">Free online bingo caller for game nights, classrooms, senior events &amp; fundraisers.</p>
</footer>

</body>
</html>
