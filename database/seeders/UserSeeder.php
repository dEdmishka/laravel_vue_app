<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Misha',
            'email' => 'user1@ukr.net',
            'password' => bcrypt(12345678),
        ]);

        User::factory()->create([
            'name' => 'John',
            'email' => 'user2@ukr.net',
            'password' => bcrypt(12345678),
        ]);

        User::factory()->create([
            'name' => 'Abram',
            'email' => 'user3@ukr.net',
            'password' => bcrypt(12345678),
        ]);
    }
}
