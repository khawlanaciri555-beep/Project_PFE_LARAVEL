<?php

namespace Database\Factories;

use App\Models\Transport;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Transport>
 */
class TransportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => $this->faker->randomElement(['car', 'bus', 'taxi', 'plane']),
            'price' => $this->faker->numberBetween(50, 500),
            'availability' => true,
            'description' => $this->faker->sentence(),
            'user_id' => \App\Models\User::factory(),
            'phone' => $this->faker->numberBetween(10000000, 99999999),
            'is_deleted' => false,
        ];
    }
}
