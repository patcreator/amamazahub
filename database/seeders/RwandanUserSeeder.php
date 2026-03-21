<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Video;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RwandanUserSeeder extends Seeder
{
    public function run(): void
    {
        $rwandanUsers = [
            ['name' => 'Keza Alice', 'username' => 'keza_alice', 'email' => 'keza@example.com'],
            ['name' => 'Mugisha Jean', 'username' => 'mugisha_j', 'email' => 'mugisha@example.com'],
            ['name' => 'Gisa Eric', 'username' => 'gisa_eric', 'email' => 'gisa@example.com'],
            ['name' => 'Ineza Marie', 'username' => 'ineza_m', 'email' => 'ineza@example.com'],
            ['name' => 'Manzi Bruno', 'username' => 'manzi_b', 'email' => 'manzi@example.com'],
            ['name' => 'Uwase Ange', 'username' => 'uwase_ange', 'email' => 'uwase@example.com'],
            ['name' => 'Shema Kevin', 'username' => 'shema_k', 'email' => 'shema@example.com'],
            ['name' => 'Mutoni Bella', 'username' => 'mutoni_b', 'email' => 'mutoni@example.com'],
            ['name' => 'Habimana Paul', 'username' => 'habimana_p', 'email' => 'habimana@example.com'],
            ['name' => 'Iradukunda Faith', 'username' => 'iradukunda_f', 'email' => 'iradukunda@example.com'],
        ];

        foreach ($rwandanUsers as $userData) {
            $user = User::create([
                'name' => $userData['name'],
                'username' => $userData['username'],
                'email' => $userData['email'],
                'password' => Hash::make('Test1234@'),
                'avatar' => "https://i.pravatar.cc/150?u={$userData['username']}",
                'bio' => "Official AmazamaHub Creator from Rwanda 🇷🇼",
            ]);

            // Create 3 videos per user
            $categories = ['Trending', 'Comedy', 'Education', 'Gaming', 'Music', 'Vlogs'];
            $videos = [
                ['url' => 'https://vjs.zencdn.net/v/oceans.mp4', 'thumb' => 'https://images.pexels.com/photos/1001633/pexels-photo-1001633.jpeg?auto=compress&cs=tinysrgb&w=600'],
                ['url' => 'https://sample-videos.com/video321/mp4/720/big_buck_bunny_720p_1mb.mp4', 'thumb' => 'https://images.pexels.com/photos/1181244/pexels-photo-1181244.jpeg?auto=compress&cs=tinysrgb&w=600'],
                ['url' => 'https://www.w3schools.com/html/mov_bbb.mp4', 'thumb' => 'https://images.pexels.com/photos/1181263/pexels-photo-1181263.jpeg?auto=compress&cs=tinysrgb&w=600'],
            ];

            foreach ($videos as $vData) {
                Video::create([
                    'user_id' => $user->id,
                    'video_url' => $vData['url'],
                    'thumbnail_url' => $vData['thumb'],
                    'caption' => "Muraho! This is my latest video from #Rwanda. Subscribe for more! 🇷🇼 #AmazamaHub #Kigali",
                    'category' => $categories[array_rand($categories)],
                    'music_name' => "Rwandan Vibes - {$user->name}",
                    'likes_count' => rand(100, 10000),
                    'comments_count' => rand(50, 500),
                ]);
            }
        }
    }
}
