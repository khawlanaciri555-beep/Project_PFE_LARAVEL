<?php

namespace Database\Seeders;

use App\Models\Place;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Database\Seeder;

class RatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // First, ensure we have at least 10 users to give diverse ratings
        if (User::count() < 10) {
            User::factory(10)->create();
        }

        $users = User::all();
        $places = Place::all();

        foreach ($places as $place) {
            // Assign 3 to 7 random ratings per place to make it look realistic
            $randomUsers = $users->random(rand(3, 7));

            foreach ($randomUsers as $user) {
                // Bias ratings toward 4 and 5 stars for high-end feel
                // Weighted: 1 (5%), 2 (5%), 3 (20%), 4 (40%), 5 (30%)
                $weights = [1, 2, 3, 3, 3, 3, 4, 4, 4, 4, 4, 4, 4, 4, 5, 5, 5, 5, 5, 5];
                $ratingValue = $weights[array_rand($weights)];

                Rating::updateOrCreate(
                    ['user_id' => $user->id, 'place_id' => $place->id],
                    ['rating' => $ratingValue]
                );
            }
        }
    }
}
