<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        $title = fake()->sentence(6);

        return [
            'user_id' => User::factory(),
            'category_id' => null,
            'title' => $title,
            'slug' => Str::slug($title).'-'.fake()->unique()->numberBetween(1, 999999),
            'excerpt' => fake()->optional()->paragraph(),
            'content' => fake()->paragraphs(5, true),
            'cover_image' => null,
            'status' => 'published',
            'read_time' => fake()->numberBetween(1, 10),
            'published_at' => now(),
        ];
    }
}
