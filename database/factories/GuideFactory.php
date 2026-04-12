<?php

namespace Database\Factories;

use App\Models\Guide;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Guide>
 */
class GuideFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'phone' => $this->faker->phoneNumber(),
            'language' => $this->faker->languageCode(),
            'experience' => $this->faker->numberBetween(1, 20) . ' years',
            'price' => $this->faker->numberBetween(100, 1000),
            'image' => $this->faker->imageUrl(),
            'description' => $this->faker->sentence(),
            'user_id' => \App\Models\User::factory(),
            'status' => true,
            'is_deleted' => false,
        ];
    }
}
