<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Contracts\View\View;

class BlogController extends Controller
{
    public function show(Post $post): View
    {
        abort_if(! $post->isPublished(), 404);

        $post->load(['author', 'category']);

        $relatedPosts = Post::with(['author', 'category'])
            ->where('status', 'published')
            ->where('published_at', '<=', now())
            ->where('id', '!=', $post->id)
            ->where('post_category_id', $post->post_category_id)
            ->orderByDesc('published_at')
            ->limit(3)
            ->get();

        return view('pages.blog.show', compact('post', 'relatedPosts'));
    }
}
