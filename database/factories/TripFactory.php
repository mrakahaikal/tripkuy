<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Trip;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Trip>
 */
class TripFactory extends Factory
{
    public function definition(): array
    {
        $destinations = ['Bali', 'Lombok', 'Raja Ampat', 'Labuan Bajo', 'Yogyakarta', 'Bromo', 'Komodo', 'Wakatobi'];
        $cities = ['Jakarta', 'Surabaya', 'Bandung', 'Semarang', 'Medan', 'Makassar'];

        $title = 'Open Trip ' . fake()->randomElement($destinations);
        $startDate = fake()->dateTimeBetween('+1 week', '+6 months');
        $durationDays = fake()->numberBetween(2, 7);
        $endDate = (clone $startDate)->modify("+{$durationDays} days");

        return [
            'category_id' => Category::factory(),
            'title' => $title,
            'slug' => Str::slug($title) . '-' . fake()->unique()->numberBetween(1000, 9999),
            'description' => fake()->paragraphs(3, true),
            'destination' => fake()->randomElement($destinations),
            'departure_city' => fake()->randomElement($cities),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'duration_days' => $durationDays,
            'price' => fake()->randomElement([500_000, 750_000, 1_000_000, 1_500_000, 2_000_000, 2_500_000]),
            'quota' => fake()->numberBetween(10, 30),
            'min_participants' => fake()->numberBetween(5, 10),
            'cover_image' => null,
            'status' => 'published',
            'meeting_point' => null,
            'includes' => ['Transportasi', 'Penginapan', 'Makan 3x sehari', 'Guide lokal'],
            'excludes' => ['Tiket pesawat', 'Asuransi perjalanan', 'Pengeluaran pribadi'],
        ];
    }

    public function draft(): static
    {
        return $this->state(['status' => 'draft']);
    }

    public function full(): static
    {
        return $this->state(['status' => 'full']);
    }

    public function cancelled(): static
    {
        return $this->state(['status' => 'cancelled']);
    }
}
