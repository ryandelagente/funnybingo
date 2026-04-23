@extends('admin.layout')

@section('title', 'All Posts')

@section('content')
<div class="page-header">
    <h1>Blog Posts</h1>
    <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">+ New Post</a>
</div>

{{-- Stats --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="num">{{ $totalPosts }}</div>
        <div class="lbl">Total Posts</div>
    </div>
    <div class="stat-card">
        <div class="num">{{ $publishedCount }}</div>
        <div class="lbl">Published</div>
    </div>
    <div class="stat-card">
        <div class="num">{{ $categoryCount }}</div>
        <div class="lbl">Categories</div>
    </div>
</div>

<div class="table-wrap">
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Category</th>
                <th>Status</th>
                <th>Published</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($posts as $post)
            <tr>
                <td style="color:#475569;">{{ $post->id }}</td>
                <td>
                    <div style="font-weight:700; color:#f1f5f9; max-width:380px;">{{ $post->title }}</div>
                    <div style="font-size:0.75rem; color:#475569; margin-top:2px;">/blog/{{ $post->slug }}</div>
                </td>
                <td><span class="badge">{{ $post->category }}</span></td>
                <td>
                    @if($post->published_at && $post->published_at <= now())
                        <span class="badge badge-green">Published</span>
                    @else
                        <span class="badge">Draft</span>
                    @endif
                </td>
                <td style="color:#64748b; font-size:0.8rem;">
                    {{ $post->published_at ? $post->published_at->format('M d, Y') : '—' }}
                </td>
                <td>
                    <div style="display:flex; gap:6px; flex-wrap:wrap;">
                        <a href="{{ route('blog.show', $post->slug) }}" target="_blank" class="btn btn-ghost btn-sm">View</a>
                        <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form method="POST" action="{{ route('admin.posts.destroy', $post) }}"
                              onsubmit="return confirm('Delete this post?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align:center; padding:40px; color:#475569;">
                    No posts yet. <a href="{{ route('admin.posts.create') }}" style="color:#16a34a;">Create your first post →</a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{ $posts->links() }}
@endsection
