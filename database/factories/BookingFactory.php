<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Booking>
 */
class BookingFactory extends Factory
{
    public function definition(): array
    {
        $participantCount = fake()->numberBetween(1, 5);
        $trip = Trip::factory();

        return [
            'booking_code' => 'TRK-' . now()->format('Ymd') . '-' . strtoupper(Str::random(6)),
            'user_id' => User::factory(),
            'trip_id' => $trip,
            'participant_count' => $participantCount,
            'total_price' => 0,
            'status' => 'pending',
            'notes' => null,
            'confirmed_at' => null,
            'cancelled_at' => null,
        ];
    }

    public function confirmed(): static
    {
        return $this->state([
            'status' => 'confirmed',
            'confirmed_at' => now(),
        ]);
    }

    public function cancelled(): static
    {
        return $this->state([
            'status' => 'cancelled',
            'cancelled_at' => now(),
        ]);
    }
}
