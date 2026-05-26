<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Review;
use App\Models\Trip;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $categories = Category::whereHas('trips', fn ($q) => $q->where('status', 'published'))
            ->withCount(['trips' => fn ($q) => $q->where('status', 'published')])
            ->get();

        $popularTrips = Trip::with(['category'])
            ->where('status', 'published')
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->orderByDesc('reviews_avg_rating')
            ->limit(6)
            ->get();

        $destinations = Trip::where('status', 'published')
            ->whereNotNull('cover_image')
            ->select(['destination', 'cover_image', 'slug'])
            ->orderByDesc('created_at')
            ->get()
            ->unique('destination')
            ->take(6)
            ->values();

        $latestReviews = Review::with(['user', 'trip'])
            ->where('rating', '>=', 4)
            ->whereNotNull('comment')
            ->orderByDesc('rating')
            ->limit(6)
            ->get();

        $latestPosts = Post::with(['author', 'category'])
            ->where('status', 'published')
            ->where('published_at', '<=', now())
            ->orderByDesc('published_at')
            ->limit(3)
            ->get();

        return view('pages.home', compact('categories', 'popularTrips', 'destinations', 'latestReviews', 'latestPosts'));
    }
}
