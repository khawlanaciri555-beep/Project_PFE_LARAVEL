<?php

namespace Database\Factories;

use App\Models\Emergency;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Emergency>
 */
class EmergencyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'type' => $this->faker->randomElement(['police', 'ambulance', 'fire']),
            'location' => $this->faker->address(),
        ];
    }
}
