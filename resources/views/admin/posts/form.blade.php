@extends('admin.layout')

@section('title', $post ? 'Edit Post' : 'New Post')

@push('styles')
<style>
    /* Simple toolbar for body editor */
    .editor-toolbar { display:flex; gap:6px; flex-wrap:wrap; margin-bottom:8px; }
    .editor-toolbar button {
        background:#334155; color:#94a3b8; border:none; border-radius:5px;
        padding:5px 10px; font-size:0.78rem; font-weight:700; cursor:pointer;
        font-family: monospace;
    }
    .editor-toolbar button:hover { background:#475569; color:#f1f5f9; }
    #body { font-family: 'Courier New', monospace; font-size:0.85rem; line-height:1.6; min-height:380px; }
    .char-count { font-size:0.75rem; color:#475569; text-align:right; margin-top:4px; }
    .char-count.warn { color:#f59e0b; }
    .char-count.over { color:#f87171; }
</style>
@endpush

@section('content')
<div class="page-header">
    <h1>{{ $post ? 'Edit Post' : 'New Post' }}</h1>
    @if($post)
        <a href="{{ route('blog.show', $post->slug) }}" target="_blank" class="btn btn-ghost">View Live →</a>
    @endif
</div>

<form method="POST"
      action="{{ $post ? route('admin.posts.update', $post) : route('admin.posts.store') }}">
    @csrf
    @if($post) @method('PUT') @endif

    <div class="card">

        {{-- Row 1: Title + Slug --}}
        <div class="form-grid">
            <div class="form-group full">
                <label for="title">Post Title *</label>
                <input type="text" id="title" name="title"
                       value="{{ old('title', $post?->title) }}"
                       placeholder="e.g. How to Host a Bingo Night" required
                       oninput="autoSlug(this.value)">
                @error('title')<div class="error-msg">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label for="slug">URL Slug</label>
                <input type="text" id="slug" name="slug"
                       value="{{ old('slug', $post?->slug) }}"
                       placeholder="auto-generated from title">
                <span class="field-hint">Leave blank to auto-generate. Example: how-to-host-bingo-night</span>
                @error('slug')<div class="error-msg">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label for="category">Category *</label>
                <select id="category" name="category" required>
                    @foreach(['guide','hosting','education','events','strategy'] as $cat)
                        <option value="{{ $cat }}"
                            {{ old('category', $post?->category) === $cat ? 'selected' : '' }}>
                            {{ ucfirst($cat) }}
                        </option>
                    @endforeach
                </select>
                @error('category')<div class="error-msg">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label for="reading_time">Reading Time *</label>
                <input type="text" id="reading_time" name="reading_time"
                       value="{{ old('reading_time', $post?->reading_time ?? '5 min read') }}"
                       placeholder="e.g. 5 min read" required>
                @error('reading_time')<div class="error-msg">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label for="published_at">Publish Date</label>
                <input type="datetime-local" id="published_at" name="published_at"
                       value="{{ old('published_at', $post?->published_at?->format('Y-m-d\TH:i')) }}">
                <span class="field-hint">Leave blank to save as draft.</span>
                @error('published_at')<div class="error-msg">{{ $message }}</div>@enderror
            </div>
        </div>

        <hr style="border:none; border-top:1px solid #334155; margin:24px 0;">

        {{-- Excerpt --}}
        <div class="form-group full" style="margin-bottom:20px;">
            <label for="excerpt">Excerpt / Summary *</label>
            <textarea id="excerpt" name="excerpt" rows="3"
                      placeholder="Short description shown on the blog index page (1–2 sentences)" required>{{ old('excerpt', $post?->excerpt) }}</textarea>
            @error('excerpt')<div class="error-msg">{{ $message }}</div>@enderror
        </div>

        {{-- Body --}}
        <div class="form-group full" style="margin-bottom:20px;">
            <label for="body">Post Body (HTML) *</label>
            <div class="editor-toolbar">
                <button type="button" onclick="wrap('&lt;h2&gt;','&lt;/h2&gt;')">H2</button>
                <button type="button" onclick="wrap('&lt;h3&gt;','&lt;/h3&gt;')">H3</button>
                <button type="button" onclick="wrap('&lt;p&gt;','&lt;/p&gt;')">¶ P</button>
                <button type="button" onclick="wrap('&lt;strong&gt;','&lt;/strong&gt;')"><b>B</b></button>
                <button type="button" onclick="wrap('&lt;em&gt;','&lt;/em&gt;')"><i>I</i></button>
                <button type="button" onclick="wrap('&lt;ul&gt;\n&lt;li&gt;','&lt;/li&gt;\n&lt;/ul&gt;')">UL</button>
                <button type="button" onclick="wrap('&lt;ol&gt;\n&lt;li&gt;','&lt;/li&gt;\n&lt;/ol&gt;')">OL</button>
                <button type="button" onclick="wrap('&lt;li&gt;','&lt;/li&gt;')">LI</button>
                <button type="button" onclick="wrap('&lt;a href=&quot;&quot;&gt;','&lt;/a&gt;')">Link</button>
            </div>
            <textarea id="body" name="body" rows="20"
                      placeholder="Write your post content in HTML..." required>{{ old('body', $post?->body) }}</textarea>
            @error('body')<div class="error-msg">{{ $message }}</div>@enderror
        </div>

        <hr style="border:none; border-top:1px solid #334155; margin:24px 0;">

        {{-- SEO fields --}}
        <p style="font-size:0.8rem; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:.04em; margin-bottom:16px;">SEO Meta (optional)</p>
        <div class="form-grid">
            <div class="form-group full">
                <label for="meta_title">Meta Title</label>
                <input type="text" id="meta_title" name="meta_title"
                       value="{{ old('meta_title', $post?->meta_title) }}"
                       placeholder="Defaults to post title | Funny Bingo">
                @error('meta_title')<div class="error-msg">{{ $message }}</div>@enderror
            </div>

            <div class="form-group full">
                <label for="meta_description">Meta Description <span id="meta-count" class="char-count"></span></label>
                <textarea id="meta_description" name="meta_description" rows="2"
                          maxlength="160"
                          placeholder="Max 160 characters — shown in Google search results">{{ old('meta_description', $post?->meta_description) }}</textarea>
                @error('meta_description')<div class="error-msg">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                {{ $post ? 'Update Post' : 'Publish Post' }}
            </button>
            <a href="{{ route('admin.posts.index') }}" class="btn btn-ghost">Cancel</a>
        </div>
    </div>
</form>

<script>
    // Auto-generate slug from title
    function autoSlug(title) {
        const slugField = document.getElementById('slug');
        if (slugField.dataset.manual) return;
        slugField.value = title.toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '')
            .trim()
            .replace(/\s+/g, '-');
    }

    document.getElementById('slug').addEventListener('input', function() {
        this.dataset.manual = '1';
    });

    // Wrap selected text with HTML tags
    function wrap(open, close) {
        const ta = document.getElementById('body');
        const start = ta.selectionStart, end = ta.selectionEnd;
        const selected = ta.value.substring(start, end);
        const decoded = s => s.replace(/&lt;/g,'<').replace(/&gt;/g,'>').replace(/&quot;/g,'"');
        ta.value = ta.value.substring(0, start) + decoded(open) + selected + decoded(close) + ta.value.substring(end);
        ta.focus();
        ta.selectionStart = start + decoded(open).length;
        ta.selectionEnd   = start + decoded(open).length + selected.length;
    }

    // Meta description character counter
    const metaDesc = document.getElementById('meta_description');
    const metaCount = document.getElementById('meta-count');
    function updateCount() {
        const len = metaDesc.value.length;
        metaCount.textContent = len + '/160';
        metaCount.className = 'char-count' + (len > 155 ? ' over' : len > 130 ? ' warn' : '');
    }
    metaDesc.addEventListener('input', updateCount);
    updateCount();
</script>
@endsection
