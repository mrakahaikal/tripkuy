<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\PostCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    public function definition(): array
    {
        $title = fake()->sentence(6);

        return [
            'post_category_id' => PostCategory::factory(),
            'user_id' => User::factory(),
            'title' => $title,
            'slug' => Str::slug($title) . '-' . fake()->unique()->numberBetween(1000, 9999),
            'excerpt' => fake()->paragraph(),
            'content' => implode("\n\n", fake()->paragraphs(5)),
            'cover_image' => null,
            'status' => 'published',
            'published_at' => now(),
        ];
    }

    public function draft(): static
    {
        return $this->state([
            'status' => 'draft',
            'published_at' => null,
        ]);
    }

    public function archived(): static
    {
        return $this->state(['status' => 'archived']);
    }
}
