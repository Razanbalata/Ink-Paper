<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::create([
            'name' => 'Technology',
            'slug' => 'technology',
            'description' => 'Articles about technology and software development.',
        ]);

        Category::create([
            'name' => 'Programming',
            'slug' => 'programming',
            'description' => 'Programming tutorials, tips, and best practices.',
        ]);

        Category::create([
            'name' => 'Artificial Intelligence',
            'slug' => 'artificial-intelligence',
            'description' => 'Articles about AI and modern intelligent technologies.',
        ]);

        Category::create([
            'name' => 'Design',
            'slug' => 'design',
            'description' => 'UI, UX, and web design articles.',
        ]);
    }
}
