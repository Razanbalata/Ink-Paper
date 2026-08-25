<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Razan Balata',
            'email' => 'razan@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'bio' => 'Full Stack Web Developer | Laravel • Next.js • React • AI Integration',
            'avatar' => null,
            'website' => null,
        ]);

        User::create([
            'name' => 'Ahmed Ali',
            'email' => 'ahmed@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'bio' => 'Software developer and technology writer.',
            'avatar' => null,
            'website' => null,
        ]);

        User::create([
            'name' => 'Sara Khaled',
            'email' => 'sara@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'bio' => 'Frontend developer and UI/UX enthusiast.',
            'avatar' => null,
            'website' => null,
        ]);
    }
}
