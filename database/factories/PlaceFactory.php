<?php

namespace Database\Factories;

use App\Models\Place;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Place>
 */
class PlaceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->city(),
            'address' => $this->faker->address(),
            'image' => $this->faker->imageUrl(),
            'description' => $this->faker->sentence(),
            'is_deleted' => false,
        ];
    }
}
