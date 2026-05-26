<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use Illuminate\Contracts\View\View;

class TripController extends Controller
{
    public function show(Trip $trip): View
    {
        abort_if($trip->status !== 'published', 404);

        $trip->load([
            'category',
            'itineraries',
            'images',
            'faqs',
            'reviews.user',
        ]);

        $trip->loadCount('reviews');
        $trip->loadAvg('reviews', 'rating');

        $relatedTrips = Trip::where('status', 'published')
            ->where('id', '!=', $trip->id)
            ->where('category_id', $trip->category_id)
            ->with('category')
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->limit(3)
            ->get();

        return view('pages.trips.show', compact('trip', 'relatedTrips'));
    }
}
