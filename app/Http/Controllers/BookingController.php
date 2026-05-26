<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Trip;
use Illuminate\Contracts\View\View;

class BookingController extends Controller
{
    public function create(Trip $trip): View
    {
        abort_if($trip->status !== 'published', 404);
        abort_if($trip->availableSlots() <= 0, 410);

        $trip->load('category');

        return view('pages.bookings.create', compact('trip'));
    }

    public function show(Booking $booking): View
    {
        return view('pages.bookings.show', compact('booking'));
    }
}
