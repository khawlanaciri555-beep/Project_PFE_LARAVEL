<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'type' => $this->faker->randomElement(['Activity', 'Experience', 'Workshop', 'Tour']),
            'image' => '/storage/places/' . \App\Models\Place::inRandomOrder()->first()?->name . '/image.png',
            'description' => $this->faker->paragraph(),
            'availability' => true,
            'is_deleted' => false,
            'cooperative_id' => \App\Models\Cooperative::inRandomOrder()->first()?->id ?? \App\Models\Cooperative::factory(),
            'place_id' => \App\Models\Place::inRandomOrder()->first()?->id ?? \App\Models\Place::factory(),
            'hotel_id' => \App\Models\Hotel::inRandomOrder()->first()?->id ?? \App\Models\Hotel::factory(),
            'transport_id' => \App\Models\Transport::inRandomOrder()->first()?->id ?? \App\Models\Transport::factory(),
            'price' => $this->faker->numberBetween(100, 5000),
            'rating' => $this->faker->randomFloat(1, 3, 5),
        ];
    }
}
