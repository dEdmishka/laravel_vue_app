<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();
        Post::factory(3)->create([
            'user_id' => $user->id,
            'body' => fake()->sentence(),
            'image' => fake()->imageUrl(),
        ]);

        $secondUser = User::firstWhere('id', '2');
        Post::factory(2)->create([
            'user_id' => $secondUser->id,
            'body' => fake()->sentence(),
            'image' => fake()->imageUrl(),
        ]);

    }
}
