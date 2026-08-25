<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        Post::create([
            'user_id' => 1,
            'category_id' => 1,
            'title' => 'Getting Started with Laravel 13',
            'slug' => 'getting-started-with-laravel-13',
            'excerpt' => 'A practical introduction to building modern web applications with Laravel 13.',
            'content' => 'Laravel is a powerful PHP framework for building modern and scalable web applications. In this article, we will explore the basics of Laravel 13 and how to get started with it.',
            'cover_image' => null,
            'status' => 'published',
            'read_time' => 5,
            'published_at' => now(),
        ]);

        Post::create([
            'user_id' => 1,
            'category_id' => 1,
            'title' => 'Building Better Laravel Applications',
            'slug' => 'building-better-laravel-applications',
            'excerpt' => 'Learn some practical techniques for writing clean and maintainable Laravel applications.',
            'content' => 'Clean architecture, proper validation, reusable components, and good database design are important parts of building maintainable Laravel applications.',
            'cover_image' => null,
            'status' => 'published',
            'read_time' => 6,
            'published_at' => now(),
        ]);

        Post::create([
            'user_id' => 2,
            'category_id' => 1,
            'title' => 'Why Developers Should Learn AI Integration',
            'slug' => 'why-developers-should-learn-ai-integration',
            'excerpt' => 'AI is becoming an important part of modern web applications.',
            'content' => 'Integrating AI into web applications can help developers build smarter experiences, automate repetitive tasks, and provide personalized features for users.',
            'cover_image' => null,
            'status' => 'published',
            'read_time' => 4,
            'published_at' => now(),
        ]);

        Post::create([
            'user_id' => 3,
            'category_id' => 1,
            'title' => 'Designing Better User Experiences',
            'slug' => 'designing-better-user-experiences',
            'excerpt' => 'Simple principles that can help you create better and more intuitive interfaces.',
            'content' => 'Good UI is not only about visual beauty. A great user experience depends on clarity, consistency, accessibility, and making important actions easy to discover.',
            'cover_image' => null,
            'status' => 'draft',
            'read_time' => 5,
            'published_at' => null,
        ]);
    }
}
