<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Video;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ExploreSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['name' => 'Comedy King', 'username' => 'funny_king', 'email' => 'funny@example.com'],
            ['name' => 'Edu Tech', 'username' => 'edutech_pro', 'email' => 'edu@example.com'],
            ['name' => 'Gamer Girl', 'username' => 'gg_gamer', 'email' => 'gamer@example.com'],
            ['name' => 'Music Vibes', 'username' => 'music_vibes', 'email' => 'music@example.com'],
            ['name' => 'Vlog Life', 'username' => 'vlog_life', 'email' => 'vlog@example.com'],
        ];

        foreach ($users as $userData) {
            $user = User::create([
                'name' => $userData['name'],
                'username' => $userData['username'],
                'email' => $userData['email'],
                'password' => Hash::make('password'),
            ]);

            // Create 5 videos per user in different categories
            $categories = ['Trending', 'Comedy', 'Education', 'Gaming', 'Music', 'Vlogs'];
            $images = [
                 'https://images.pexels.com/photos/2161467/pexels-photo-2161467.jpeg?auto=compress&cs=tinysrgb&w=600',
                 'https://images.pexels.com/photos/442576/pexels-photo-442576.jpeg?auto=compress&cs=tinysrgb&w=600',
                 'https://images.pexels.com/photos/1671325/pexels-photo-1671325.jpeg?auto=compress&cs=tinysrgb&w=600',
                 'https://images.pexels.com/photos/774909/pexels-photo-774909.jpeg?auto=compress&cs=tinysrgb&w=600',
                 'https://images.pexels.com/photos/3408744/pexels-photo-3408744.jpeg?auto=compress&cs=tinysrgb&w=600',
                 'https://images.pexels.com/photos/1624496/pexels-photo-1624496.jpeg?auto=compress&cs=tinysrgb&w=600'
            ];

            for ($i = 0; $i < 6; $i++) {
                Video::create([
                    'user_id' => $user->id,
                    'video_url' => 'https://www.w3schools.com/html/mov_bbb.mp4',
                    'thumbnail_url' => $images[$i],
                    'caption' => "Check out this amazing {$categories[$i]} content! #AmazamaHub #{$categories[$i]}",
                    'category' => $categories[$i],
                    'music_name' => "Original Sound - {$user->username}",
                    'likes_count' => rand(100, 5000),
                    'comments_count' => rand(10, 500),
                ]);
            }
        }
    }
}
