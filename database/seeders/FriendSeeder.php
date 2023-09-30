<?php

namespace Database\Seeders;

use App\Models\Friend;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FriendSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();
        $lastUser = User::firstWhere('id', '3');
        Friend::factory(1)->create([
            'user_id' => $user->id,
            'friend_id' => $lastUser->id,
            'status' => 1,
            'confirmed_at' => now(),
        ]);
    }
}
