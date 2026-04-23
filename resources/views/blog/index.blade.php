@extends('layouts.app')

@push('schema')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Blog",
  "name": "Funny Bingo Blog",
  "url": "{{ route('blog.index') }}",
  "description": "Bingo guides, tips, hosting advice, and educational resources.",
  "publisher": {
    "@type": "Person",
    "name": "Ryan Jison de la Gente"
  }
}
</script>
@endpush

@section('content')
<div style="max-width:1100px; margin:0 auto; padding:40px 20px;">
    <h1 style="font-size:2rem; font-weight:900; color:#fbbf24; margin-bottom:8px;">Bingo Tips &amp; Guides</h1>
    <p style="color:#94a3b8; margin-bottom:24px;">Everything you need to know about bingo — how to play, host, and win.</p>

    {{-- Category filter --}}
    <div style="display:flex; gap:8px; flex-wrap:wrap; margin-bottom:30px;">
        <a href="{{ route('blog.index') }}"
           style="padding:6px 16px; border-radius:20px; font-size:0.8rem; font-weight:700; text-decoration:none; text-transform:uppercase;
                  {{ !$activeCategory ? 'background:#fbbf24; color:#000;' : 'background:#1f2937; color:#94a3b8;' }}">
            All
        </a>
        @foreach($categories as $cat)
        <a href="{{ route('blog.index', ['category' => $cat]) }}"
           style="padding:6px 16px; border-radius:20px; font-size:0.8rem; font-weight:700; text-decoration:none; text-transform:uppercase;
                  {{ $activeCategory === $cat ? 'background:#fbbf24; color:#000;' : 'background:#1f2937; color:#94a3b8;' }}">
            {{ $cat }}
        </a>
        @endforeach
    </div>

    <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(300px, 1fr)); gap:20px;">
        @foreach($posts as $post)
        <article style="background:#111827; border:1px solid #1f2937; border-radius:12px; padding:22px; display:flex; flex-direction:column; gap:10px;">
            <div style="display:flex; align-items:center; gap:8px;">
                <span style="background:#1f2937; border-radius:4px; padding:2px 8px; font-size:0.7rem; font-weight:700; color:#94a3b8; text-transform:uppercase;">{{ $post->category }}</span>
                <span style="font-size:0.75rem; color:#475569;">{{ $post->reading_time }}</span>
            </div>
            <h2 style="font-size:1.05rem; font-weight:800; color:#f8fafc; margin:0; line-height:1.4;">
                <a href="{{ route('blog.show', $post->slug) }}" style="color:inherit; text-decoration:none;">{{ $post->title }}</a>
            </h2>
            <p style="font-size:0.875rem; color:#94a3b8; margin:0; line-height:1.6; flex:1;">{{ $post->excerpt }}</p>
            <a href="{{ route('blog.show', $post->slug) }}"
               style="display:inline-block; color:#16a34a; font-weight:700; font-size:0.85rem; text-decoration:none; margin-top:auto;">
                Read More &rarr;
            </a>
        </article>
        @endforeach
    </div>

    {{ $posts->links() }}
</div>
@endsection
