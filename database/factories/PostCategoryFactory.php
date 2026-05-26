<?php

namespace Database\Factories;

use App\Models\PostCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<PostCategory>
 */
class PostCategoryFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->unique()->randomElement([
            'Tips Perjalanan', 'Destinasi', 'Kuliner', 'Budaya', 'Petualangan', 'Panduan Wisata',
        ]);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->sentence(),
        ];
    }
}
