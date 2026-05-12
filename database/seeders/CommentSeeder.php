<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = \App\Models\User::first();
        $place = \App\Models\Place::first();
        $transport = \App\Models\Transport::first();
        
        if (!$user) return;

        // Create a dummy cooperative if none exists
        $cooperative = \App\Models\Cooperative::first();
        if (!$cooperative && $place) {
            $cooperative = \App\Models\Cooperative::create([
                'name' => 'Argan Valley Cooperative',
                'description' => 'A local cooperative producing high-quality argan oil.',
                'address' => 'Ourika Valley, Marrakech',
                'user_id' => $user->id,
                'place_id' => $place->id,
            ]);
        }

        $comments = [
            [
                'user_id' => $user->id,
                'content' => "The transport service was exceptional! The driver was punctual and very professional. Highly recommend for trips around Marrakech.",
                'transport_id' => $transport->id ?? null,
            ],
            [
                'user_id' => $user->id,
                'content' => "Visiting the Argan Valley Cooperative was a highlight of our trip. The women there are so skilled and the oil is pure and authentic.",
                'cooperative_id' => $cooperative->id ?? null,
            ],
            [
                'user_id' => $user->id,
                'content' => "Jemaa el-Fnaa is a must-see! The atmosphere at night is magical. Thanks for the recommendations!",
                'place_id' => $place->id ?? null,
            ],
            [
                'user_id' => $user->id,
                'content' => "I loved the traditional weaving demonstration at the cooperative. Such a rich cultural experience.",
                'cooperative_id' => $cooperative->id ?? null,
            ],
            [
                'user_id' => $user->id,
                'content' => "The private shuttle was very comfortable and saved us a lot of time. Great value for money.",
                'transport_id' => $transport->id ?? null,
            ],
        ];

        foreach ($comments as $commentData) {
            \App\Models\Comment::create($commentData);
        }
    }
}
