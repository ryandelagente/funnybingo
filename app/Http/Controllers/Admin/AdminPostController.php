<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminPostController extends Controller
{
    public function index()
    {
        $posts          = Post::latest()->paginate(20);
        $totalPosts     = Post::count();
        $publishedCount = Post::whereNotNull('published_at')->where('published_at', '<=', now())->count();
        $categoryCount  = Post::distinct('category')->count('category');

        return view('admin.posts.index', compact('posts', 'totalPosts', 'publishedCount', 'categoryCount'));
    }

    public function create()
    {
        return view('admin.posts.form', ['post' => null]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug($request->slug ?: $request->title);

        $post = Post::create($data);

        if ($post->published_at) {
            $this->pingSitemaps();
        }

        return redirect()->route('admin.posts.index')
                         ->with('success', 'Post published successfully.');
    }

    public function edit(Post $post)
    {
        return view('admin.posts.form', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $data = $this->validated($request);

        $newSlug = $request->slug ?: $request->title;
        if (Str::slug($newSlug) !== $post->slug) {
            $data['slug'] = $this->uniqueSlug($newSlug, $post->id);
        }

        $post->update($data);

        if ($post->published_at) {
            $this->pingSitemaps();
        }

        return redirect()->route('admin.posts.index')
                         ->with('success', 'Post updated successfully.');
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('admin.posts.index')
                         ->with('success', 'Post deleted.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title'            => 'required|string|max:255',
            'slug'             => 'nullable|string|max:255',
            'category'         => 'required|string|max:100',
            'reading_time'     => 'required|string|max:50',
            'excerpt'          => 'required|string',
            'body'             => 'required|string',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:160',
            'published_at'     => 'nullable|date',
        ]);
    }

    private function pingSitemaps(): void
    {
        $sitemapUrl = urlencode(url('/sitemap.xml'));
        $endpoints  = [
            "https://www.google.com/ping?sitemap={$sitemapUrl}",
            "https://www.bing.com/ping?sitemap={$sitemapUrl}",
        ];

        foreach ($endpoints as $endpoint) {
            try {
                $ctx = stream_context_create(['http' => ['timeout' => 5, 'ignore_errors' => true]]);
                @file_get_contents($endpoint, false, $ctx);
            } catch (\Throwable) {
                // Ping failure is non-fatal
            }
        }
    }

    private function uniqueSlug(string $value, ?int $excludeId = null): string
    {
        $slug = Str::slug($value);
        $original = $slug;
        $count = 1;

        while (
            Post::where('slug', $slug)
                ->when($excludeId, fn($q) => $q->where('id', '!=', $excludeId))
                ->exists()
        ) {
            $slug = $original . '-' . $count++;
        }

        return $slug;
    }
}
