<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\Participant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Participant>
 */
class ParticipantFactory extends Factory
{
    public function definition(): array
    {
        return [
            'booking_id' => Booking::factory(),
            'name' => fake()->name(),
            'id_number' => fake()->numerify('################'),
            'date_of_birth' => fake()->dateTimeBetween('-60 years', '-17 years'),
            'gender' => fake()->randomElement(['male', 'female']),
            'phone' => fake()->phoneNumber(),
            'emergency_contact_name' => fake()->name(),
            'emergency_contact_phone' => fake()->phoneNumber(),
        ];
    }
}
