@extends('layouts.app')

@push('schema')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@graph": [
    {
      "@type": "AboutPage",
      "@id": "{{ route('page.about') }}/#webpage",
      "url": "{{ route('page.about') }}",
      "name": "About Funny Bingo",
      "description": "Learn about Funny Bingo — a free browser-based bingo caller built by Ryan Jison de la Gente for game nights, classrooms, fundraisers, and more.",
      "isPartOf": { "@id": "{{ url('/') }}/#website" },
      "breadcrumb": {
        "@type": "BreadcrumbList",
        "itemListElement": [
          { "@type": "ListItem", "position": 1, "name": "Home", "item": "{{ url('/') }}" },
          { "@type": "ListItem", "position": 2, "name": "About", "item": "{{ route('page.about') }}" }
        ]
      }
    },
    {
      "@type": "Person",
      "name": "Ryan Jison de la Gente",
      "url": "{{ url('/') }}",
      "worksFor": { "@id": "{{ url('/') }}/#organization" }
    }
  ]
}
</script>
@endpush

@section('content')
<div class="content-wrap">
    <h1>About Funny Bingo</h1>
    <p class="post-meta">
        <span>Free Online Bingo Platform</span>
    </p>

    <p>
        Funny Bingo is a free, browser-based bingo caller and card generator built for anyone who loves bingo — whether you're hosting a game night with friends, running a classroom activity, organizing a fundraiser, or entertaining residents at a senior center.
    </p>

    <p>
        No downloads. No registration. No cost. Just open it in your browser, hit <strong>CALL NEXT BALL</strong>, and you're ready to play.
    </p>

    <h2>What Makes Funny Bingo Different?</h2>
    <p>
        Most bingo callers are clunky desktop apps or expensive software subscriptions. Funny Bingo was designed from the ground up to work on any device — phone, tablet, or computer — with a clean, modern interface that's easy for hosts and players alike.
    </p>
    <ul>
        <li><strong>Voice-Enabled Calls</strong> — The browser reads each ball aloud so you don't have to.</li>
        <li><strong>15 Unique Patterns</strong> — From classic X-Shape to Heart, Diamond, and Blackout.</li>
        <li><strong>QR Player Cards</strong> — Players scan a QR code on their phone to get a digital card instantly.</li>
        <li><strong>Auto-Call Mode</strong> — Set a timer and let the game run itself between 3 and 15 seconds.</li>
        <li><strong>Dark &amp; Light Themes</strong> — Looks great in a dimly lit bingo hall or a bright classroom.</li>
        <li><strong>Mobile Host View</strong> — A special optimized layout for hosts running the game from a smartphone.</li>
    </ul>

    <h2>Who Is It For?</h2>
    <ul>
        <li><strong>Game Night Hosts</strong> — Family reunions, parties, office events</li>
        <li><strong>Teachers</strong> — Classroom bingo for vocabulary, math, and more</li>
        <li><strong>Event Organizers</strong> — Fundraisers, charity nights, community events</li>
        <li><strong>Senior Centers</strong> — Easy-to-use, large display, voice announcements</li>
        <li><strong>Online Game Hosts</strong> — Share your screen on Zoom or Google Meet</li>
    </ul>

    <h2>The Story</h2>
    <p>
        Funny Bingo was created by <strong>Ryan Jison de la Gente</strong> in December 2025 after struggling to find a simple, modern bingo caller that worked well on mobile. Built with love for the Filipino bingo community and anyone who enjoys a good bingo night.
    </p>

    <h2>Completely Free, Forever</h2>
    <p>
        Funny Bingo will always be free to use. The site is supported by Google AdSense advertising, which allows us to keep the lights on without charging users. We appreciate your support by keeping ads enabled.
    </p>

    <div style="margin-top:30px; padding:20px; background:#111827; border-radius:12px; border:1px solid #1f2937; text-align:center;">
        <p style="margin:0; font-size:1.1rem; color:#fbbf24; font-weight:900;">Ready to play?</p>
        <a href="{{ route('bingo.index') }}" style="display:inline-block; margin-top:12px; background:#16a34a; color:#000; padding:12px 30px; border-radius:8px; font-weight:900; text-decoration:none; font-size:1rem;">Launch Funny Bingo &rarr;</a>
    </div>
</div>
@endsection
