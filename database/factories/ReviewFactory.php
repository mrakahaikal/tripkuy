<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\Review;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Review>
 */
class ReviewFactory extends Factory
{
    public function definition(): array
    {
        $booking = Booking::factory()->confirmed()->create();

        return [
            'trip_id' => $booking->trip_id,
            'user_id' => $booking->user_id,
            'booking_id' => $booking->id,
            'rating' => fake()->numberBetween(3, 5),
            'comment' => fake()->paragraph(),
        ];
    }
}
