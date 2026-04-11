<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $this->call([
            PlaceSeeder::class,
            HotelSeeder::class,
            CooperativeSeeder::class,
            TransportSeeder::class,
            ServiceSeeder::class,
            BookingSeeder::class,
            FavoriteSeeder::class,
            PlanningSeeder::class,
            PlanningItemSeeder::class,
            EmergencySeeder::class,
            RatingSeeder::class,
        ]);
    }
}
