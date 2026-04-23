@if ($paginator->hasPages())
<nav style="display:flex; align-items:center; justify-content:center; gap:6px; margin-top:24px; flex-wrap:wrap;">

    {{-- Previous --}}
    @if ($paginator->onFirstPage())
        <span style="padding:6px 14px; border-radius:6px; background:#1e293b; color:#475569; cursor:default; font-size:0.85rem;">« Prev</span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
           style="padding:6px 14px; border-radius:6px; background:#1e293b; color:#94a3b8; text-decoration:none; font-size:0.85rem; border:1px solid #334155; transition:background .15s;"
           onmouseover="this.style.background='#334155'" onmouseout="this.style.background='#1e293b'">« Prev</a>
    @endif

    {{-- Page Numbers --}}
    @foreach ($elements as $element)
        @if (is_string($element))
            <span style="padding:6px 10px; color:#475569; font-size:0.85rem;">…</span>
        @endif
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <span style="padding:6px 14px; border-radius:6px; background:#16a34a; color:#fff; font-size:0.85rem; font-weight:700;">{{ $page }}</span>
                @else
                    <a href="{{ $url }}"
                       style="padding:6px 14px; border-radius:6px; background:#1e293b; color:#94a3b8; text-decoration:none; font-size:0.85rem; border:1px solid #334155;"
                       onmouseover="this.style.background='#334155'" onmouseout="this.style.background='#1e293b'">{{ $page }}</a>
                @endif
            @endforeach
        @endif
    @endforeach

    {{-- Next --}}
    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" rel="next"
           style="padding:6px 14px; border-radius:6px; background:#1e293b; color:#94a3b8; text-decoration:none; font-size:0.85rem; border:1px solid #334155;"
           onmouseover="this.style.background='#334155'" onmouseout="this.style.background='#1e293b'">Next »</a>
    @else
        <span style="padding:6px 14px; border-radius:6px; background:#1e293b; color:#475569; cursor:default; font-size:0.85rem;">Next »</span>
    @endif

</nav>
@endif
