@extends('layouts.app')

@push('schema')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@graph": [
    {
      "@type": "Article",
      "@id": "{{ route('blog.show', $post->slug) }}/#article",
      "headline": "{{ $post->title }}",
      "description": "{{ $post->meta_description ?? $post->excerpt }}",
      "author": {
        "@type": "Person",
        "name": "Ryan Jison de la Gente"
      },
      "publisher": {
        "@id": "{{ url('/') }}/#organization"
      },
      "datePublished": "{{ $post->published_at?->toIso8601String() }}",
      "dateModified": "{{ $post->updated_at->toIso8601String() }}",
      "url": "{{ route('blog.show', $post->slug) }}",
      "image": {
        "@type": "ImageObject",
        "url": "{{ asset('images/og-image.svg') }}",
        "width": 1200,
        "height": 630
      },
      "mainEntityOfPage": {
        "@type": "WebPage",
        "@id": "{{ route('blog.show', $post->slug) }}"
      },
      "isPartOf": {
        "@id": "{{ url('/') }}/#website"
      },
      "wordCount": {{ str_word_count(strip_tags($post->body)) }},
      "articleSection": "{{ ucfirst($post->category) }}"
    },
    {
      "@type": "BreadcrumbList",
      "itemListElement": [
        {
          "@type": "ListItem",
          "position": 1,
          "name": "Home",
          "item": "{{ url('/') }}"
        },
        {
          "@type": "ListItem",
          "position": 2,
          "name": "Blog",
          "item": "{{ route('blog.index') }}"
        },
        {
          "@type": "ListItem",
          "position": 3,
          "name": "{{ $post->title }}",
          "item": "{{ route('blog.show', $post->slug) }}"
        }
      ]
    }
  ]
}
</script>
@endpush

@section('content')
<div class="content-wrap">

    {{-- Breadcrumb --}}
    <nav style="font-size:0.8rem; color:#64748b; margin-bottom:20px;">
        <a href="{{ route('bingo.index') }}" style="color:#94a3b8; text-decoration:none;">Home</a>
        &rsaquo;
        <a href="{{ route('blog.index') }}" style="color:#94a3b8; text-decoration:none;">Blog</a>
        &rsaquo;
        <span>{{ $post->title }}</span>
    </nav>

    <div class="post-meta">
        <span class="tag">{{ $post->category }}</span>
        <span>{{ $post->reading_time }}</span>
        @if($post->published_at)
            <span>{{ $post->published_at->format('F j, Y') }}</span>
        @endif
    </div>

    <h1>{{ $post->title }}</h1>

    {{-- Ad slot above content --}}
    @if(config('app.adsense_client'))
    <div class="ad-slot">
        <ins class="adsbygoogle"
             style="display:block"
             data-ad-client="{{ config('app.adsense_client') }}"
             data-ad-format="auto"
             data-full-width-responsive="true"></ins>
        <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
    </div>
    @endif

    <div style="line-height:1.8;">
        {!! $post->body !!}
    </div>

    {{-- Ad slot below content --}}
    @if(config('app.adsense_client'))
    <div class="ad-slot">
        <ins class="adsbygoogle"
             style="display:block"
             data-ad-client="{{ config('app.adsense_client') }}"
             data-ad-format="auto"
             data-full-width-responsive="true"></ins>
        <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
    </div>
    @endif

    {{-- CTA --}}
    <div style="margin:30px 0; padding:20px; background:#111827; border-radius:12px; border:1px solid #1f2937; text-align:center;">
        <p style="color:#fbbf24; font-weight:900; font-size:1.1rem; margin:0 0 10px;">Try Funny Bingo for Free</p>
        <p style="color:#94a3b8; font-size:0.875rem; margin:0 0 15px;">No downloads. No sign-up. Works on any device.</p>
        <a href="{{ route('bingo.index') }}" style="background:#16a34a; color:#000; padding:12px 28px; border-radius:8px; font-weight:900; text-decoration:none; font-size:0.95rem;">Launch the Bingo Caller &rarr;</a>
    </div>

    {{-- Related posts --}}
    @if($related->count())
    <div style="margin-top:40px;">
        <h2 style="color:#fbbf24; font-size:1.2rem;">Related Articles</h2>
        <div style="display:grid; grid-template-columns:repeat(auto-fill,minmax(240px,1fr)); gap:15px; margin-top:15px;">
            @foreach($related as $r)
            <a href="{{ route('blog.show', $r->slug) }}"
               style="background:#111827; border:1px solid #1f2937; border-radius:10px; padding:15px; text-decoration:none; display:block;">
                <span style="font-size:0.7rem; color:#64748b; text-transform:uppercase;">{{ $r->category }}</span>
                <p style="color:#f8fafc; font-weight:700; margin:6px 0 0; font-size:0.9rem; line-height:1.4;">{{ $r->title }}</p>
            </a>
            @endforeach
        </div>
    </div>
    @endif

    <div style="margin-top:30px; padding-top:20px; border-top:1px solid #1f2937;">
        <a href="{{ route('blog.index') }}" style="color:#2563eb; text-decoration:none; font-weight:700;">&larr; Back to Blog</a>
    </div>
</div>
@endsection
