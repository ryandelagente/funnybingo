{{--
    Funny Bingo - Mobile Host
    © 2025 Ryan Jison de la Gente. All Rights Reserved.
    Unauthorized copying of this file, via any medium, is strictly prohibited.
    Proprietary and confidential.
--}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Mobile Bingo Caller - Funny Bingo</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

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
    <style>
        /* UI Overrides for Mobile Host Experience */
        body {
            overflow-y: auto;
            height: auto;
            display: block;
            background-color: var(--bg);
            color: var(--text);
            padding-bottom: 40px;
        }

        .mobile-layout {
            display: flex;
            flex-direction: column;
            gap: 12px;
            padding: 10px;
            width: 100%;
            box-sizing: border-box;
        }

        .pillar {
            background: var(--panel);
            border-radius: 12px;
            border: 1px solid var(--border);
            padding: 15px;
            width: 100%;
        }

        /* Fixed Master Grid Overflow */
        .grid-scroll-container {
            width: 100%;
            overflow-x: auto;
            background: #000;
            border-radius: 8px;
            padding: 8px 5px;
            -webkit-overflow-scrolling: touch;
            border: 1px solid var(--border);
        }

        .master-grid {
            display: grid;
            grid-template-columns: 32px repeat(15, 24px);
            gap: 2px;
            width: max-content;
        }

        .cell {
            height: 26px;
            font-size: 0.8rem !important;
            border-radius: 4px;
        }

        .letter-cell {
            font-size: 1.1rem !important;
            background: transparent;
            font-weight: 900;
        }

        /* Caller Controls */
        .main-ball-circle {
            width: 100px;
            height: 100px;
            font-size: 3.5rem;
            border-width: 5px;
            margin-bottom: 10px;
        }

        .call-text-display {
            font-size: 1.8rem !important;
            margin-bottom: 15px;
            text-align: center;
        }

        .voice-box {
            background: rgba(255, 255, 255, 0.05);
            padding: 12px;
            border-radius: 10px;
            margin: 10px 0;
            text-align: center;
            border: 1px solid var(--border);
        }

        /* QR Section */
        .qr-section {
            text-align: center;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid var(--border);
        }

        .qr-holder {
            background: white;
            padding: 10px;
            display: inline-block;
            border-radius: 8px;
            margin-top: 10px;
        }

        /* Pattern List Adjustment */
        #p-scroll {
            max-height: 160px;
            overflow-y: auto;
            border: 1px solid var(--border);
            padding: 5px;
            border-radius: 8px;
        }

        .btn-call { width: 100%; font-size: 1.3rem; padding: 15px; }
        .btn-bingo { width: 100%; margin-top: 10px; }
    </style>
</head>
<body>

    <div class="status-ribbon">
        <span>BALLS: <b id="stat-count" style="color:var(--color-g)">0</b>/75</span>
        <button onclick="toggleTheme()" class="theme-btn">THEME</button>
    </div>

    <div class="mobile-layout">
        <div class="pillar">
            <div id="ball-circle" class="main-ball-circle">--</div>
            <div id="call-text" class="call-text-display">READY</div>

            <button class="btn-call" onclick="drawBall()">CALL NEXT BALL</button>

            <div class="voice-box">
                <label style="cursor:pointer; font-weight: 800; display: flex; align-items: center; justify-content: center; gap: 8px;">
                    <input type="checkbox" id="voice-toggle" checked> 🔊 VOICE ENABLED
                </label>
            </div>

            <div class="auto-controls" style="display:flex; align-items:center; gap:10px; justify-content:center; margin-bottom: 10px;">
                <button id="auto-btn" onclick="toggleAutoCall()" class="theme-btn" style="padding: 10px; font-weight: bold;">AUTO OFF</button>
                <input type="range" id="auto-speed" min="3" max="15" value="7">
                <span id="speed-label" style="font-size: 0.9rem;">7s</span>
            </div>

            <button class="btn-bingo" onclick="triggerBingo()">BINGO!</button>

            <div class="qr-section">
                <p style="font-size: 0.75rem; color: #94a3b8; margin: 0;">PLAYERS SCAN TO JOIN:</p>
                <div class="qr-holder">
                    <div id="qrcode"></div>
                </div>
            </div>
        </div>

        <div class="pillar">
            <p style="font-size: 0.65rem; color: #64748b; text-align: center; margin-bottom: 8px; text-transform: uppercase;">← Swipe Board Left/Right →</p>
            <div class="grid-scroll-container">
                <div class="master-grid" id="master-grid"></div>
            </div>
            <div class="history-tray" id="history-tray" style="margin-top: 15px;"></div>
        </div>

        <div class="pillar">
            <div class="p-monitor">
                <div id="p-name">X-SHAPE</div>
                <div class="p-preview-grid" id="p-preview"></div>
            </div>
            <div class="p-list-scroll" id="p-scroll"></div>
            <button class="btn-reset" style="width:100%; margin-top: 15px;" onclick="resetGame()">RESET GAME</button>
        </div>
    </div>

    <div id="ball-pop-overlay">
        <div id="pop-ball" class="pop-ball" style="width: 280px; height: 280px; border-width: 12px;">
            <div id="pop-l" class="pop-l" style="font-size: 3rem;">B</div>
            <div id="pop-n" class="pop-n" style="font-size: 7rem;">1</div>
        </div>
    </div>

    <script src="{{ asset('js/script.js') }}"></script>
    <script>
        if (document.getElementById('qrcode')) {
            new QRCode(document.getElementById("qrcode"), {
                text: window.location.origin + "/?role=player",
                width: 130,
                height: 130,
                colorDark : "#111827",
                colorLight : "#ffffff"
            });
        }

        function showPop(n, l) {
            const pop = document.getElementById('pop-ball');
            document.getElementById('pop-l').textContent = l;
            document.getElementById('pop-n').textContent = n;
            pop.style.borderColor = `var(--color-${l.toLowerCase()})`;
            pop.classList.remove('fade');
            pop.classList.add('active');
            setTimeout(() => {
                pop.classList.add('fade');
                setTimeout(() => pop.classList.remove('active'), 600);
            }, 2000);
        }
    </script>
</body>
</html>
