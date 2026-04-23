{{--
    Funny Bingo
    © 2025 Ryan Jison de la Gente. All Rights Reserved.
    Unauthorized copying of this file, via any medium, is strictly prohibited.
    Proprietary and confidential.
--}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Funny Bingo App - Interactive Bingo Caller & Pattern Station</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.png') }}">
    <meta name="description" content="Experience the ultimate Funny Bingo station! Use our free interactive caller with automated drawing, voice-enabled calls, and custom patterns like X-Shape and Heart. Perfect for your next bingo night.">
    <meta name="keywords" content="funny bingo, bingo patterns, bingo caller, bingo app, bingo game, bingo philippines, bingo card generator, pinoy bingo, blackout bingo, filipino bingo">
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
</head>
<body id="main-body" class="{{ $isPlayer ? 'player-mode' : '' }}">

<nav class="top-nav">
    <a href="{{ route('bingo.index') }}" class="nav-brand">Funny Bingo</a>
    <ul class="nav-links">
        <li><a href="{{ route('bingo.index') }}" class="active">GAME</a></li>
        <li><a href="{{ route('blog.index') }}">BLOG</a></li>
        <li><a href="{{ route('page.about') }}">ABOUT</a></li>
        <li><a href="{{ route('page.contact') }}">CONTACT</a></li>
    </ul>
</nav>

@if (!$isPlayer)
    <div class="status-ribbon">
        <span id="stat-time">00:00:00</span>
        <span>BALLS CALLED: <b id="stat-count" style="color:var(--color-g)">0</b>/75</span>
        <span>
            <button onclick="toggleHelp()" class="theme-btn" style="color:var(--pattern-gold); border-color:var(--pattern-gold);">HELP / INSTRUCTIONS</button>
            <button onclick="toggleTheme()" class="theme-btn">THEME</button>
        </span>
    </div>

    <div id="ball-pop-overlay">
        <div id="pop-ball" class="pop-ball">
            <div id="pop-l" class="pop-l">B</div>
            <div id="pop-n" class="pop-n">1</div>
        </div>
    </div>

    <div class="game-title"><span>B</span><span>I</span><span>N</span><span>G</span><span>O</span> STATION</div>

    <div class="desktop-container">
        <div class="pillar">
            <div id="ball-circle" class="main-ball-circle">--</div>
            <div id="call-text" class="call-text-display">READY</div>

            <button class="btn-call" onclick="drawBall()">CALL NEXT BALL</button>

            <div class="auto-controls" style="display:flex; align-items:center; gap:10px; justify-content:center;">
                <button id="auto-btn" onclick="toggleAutoCall()" class="auto-btn" style="background:#475569; color:white; border:none; padding:8px 12px; border-radius:8px; cursor:pointer; font-weight:bold;">AUTO OFF</button>
                <input type="range" id="auto-speed" min="3" max="15" value="7">
                <span id="speed-label" style="font-size:0.8rem">7s</span>
            </div>

            <button class="btn-bingo" onclick="triggerBingo()">BINGO!</button>
            <button class="btn-reset" onclick="resetGame()">RESET GAME</button>

            <div class="qr-container" style="margin-top: 10px;">
                <p style="font-size: 0.7rem; margin-bottom: 5px; color: #94a3b8;">SCAN FOR PLAYER CARD</p>
                <div id="qrcode"></div>
            </div>

            <div class="voice-box" style="margin-top: 10px;">
                <label style="cursor:pointer; font-size: 0.85rem;"><input type="checkbox" id="voice-toggle" checked> Voice Enabled</label>
            </div>
        </div>

        <div class="pillar">
            <div class="master-grid" id="master-grid"></div>
            <div class="history-tray" id="history-tray"></div>
        </div>

        <div class="pillar">
            <div class="p-monitor">
                <div id="p-name">X-SHAPE</div>
                <div class="p-preview-grid" id="p-preview"></div>
            </div>
            <div class="p-list-scroll" id="p-scroll"></div>
        </div>
    </div>

@else
    <div class="player-container">
        <div class="game-title" style="font-size: 1.8rem; letter-spacing: 2px;">YOUR CARD</div>
        <div id="player-card-grid" class="player-grid"></div>
        <button class="btn-call" style="margin-top:20px; width:100%;" onclick="generatePlayerCard()">GET NEW CARD</button>
        <p style="font-size: 0.9rem; margin-top: 15px; color: #94a3b8;">Tap numbers to mark them!</p>
        <a href="{{ route('bingo.index') }}" style="display:block; margin-top:20px; color:var(--color-b); text-decoration:none; font-size:0.8rem;">Exit Player Mode</a>
    </div>
@endif

<div class="copyright">&copy; {{ date('Y') }} Ryan Jison de la Gente. All Rights Reserved.</div>

<div id="help-modal" class="help-overlay" onclick="toggleHelp()">
    <div class="help-content" onclick="event.stopPropagation()">
        <button class="close-help" onclick="toggleHelp()">&times;</button>
        <h2 style="color:var(--color-g)">FUNNY BINGO GUIDE</h2>
        <div class="help-grid">
            <div class="help-section">
                <h3>Host Instructions</h3>
                <ul>
                    <li><strong>Calling:</strong> Use "CALL NEXT BALL" or "AUTO".</li>
                    <li><strong>Patterns:</strong> Select patterns like X-Shape or Blackout.</li>
                    <li><strong>Reset:</strong> Clear the board for a new round.</li>
                </ul>
            </div>
            <div class="help-section">
                <h3>Player Instructions</h3>
                <ul>
                    <li><strong>Join:</strong> Scan the QR code for a digital card.</li>
                    <li><strong>Marking:</strong> Tap numbers to mark them green.</li>
                    <li><strong>Winning:</strong> Complete the pattern and shout BINGO!.</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/script.js') }}"></script>
<script>
    if (document.getElementById('qrcode')) {
        new QRCode(document.getElementById("qrcode"), {
            text: window.location.origin + "/?role=player",
            width: 128,
            height: 128,
            colorDark : "#111827",
            colorLight : "#ffffff"
        });
    }

    function toggleHelp() {
        document.getElementById('help-modal').classList.toggle('active');
    }
</script>
</body>
</html>
