<?php

namespace Database\Factories;

use App\Models\Hotel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Hotel>
 */
class HotelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => $this->faker->randomElement(['hotel','resort', 'apartment', 'villa','riad', 'other']),
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->safeEmail(),
            'address' => $this->faker->address(),
            'image' => $this->faker->imageUrl(),
            'price' => $this->faker->numberBetween(200, 5000),
            'description' => $this->faker->sentence(),
            'user_id' => \App\Models\User::factory(),
            'availability' => true,
            'is_deleted' => false,
        ];
    }
}
