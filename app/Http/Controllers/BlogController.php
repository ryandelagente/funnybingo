<?php

namespace App\Http\Controllers;

use App\Models\Post;

class BlogController extends Controller
{
    public function index()
    {
        $category   = request('category');
        $categories = Post::published()->distinct()->orderBy('category')->pluck('category');

        $posts = Post::published()
            ->when($category, fn($q) => $q->where('category', $category))
            ->latest('published_at')
            ->paginate(9)
            ->withQueryString();

        return view('blog.index', [
            'posts'            => $posts,
            'categories'       => $categories,
            'activeCategory'   => $category,
            'meta_title'       => 'Bingo Tips, Guides & Articles | Funny Bingo Blog',
            'meta_description' => 'Explore bingo guides, hosting tips, pattern explanations, classroom ideas, and more. Your go-to resource for everything bingo.',
        ]);
    }

    public function show(Post $post)
    {
        return view('blog.show', [
            'post'             => $post,
            'meta_title'       => ($post->meta_title ?: $post->title) . ' | Funny Bingo',
            'meta_description' => $post->meta_description ?: $post->excerpt,
            'related'          => Post::published()
                                      ->where('id', '!=', $post->id)
                                      ->where('category', $post->category)
                                      ->latest('published_at')
                                      ->limit(3)
                                      ->get(),
        ]);
    }
}
