<?php

namespace Database\Factories;

use App\Models\Planning;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Planning>
 */
class PlanningFactory extends Factory
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
            'start_date' => $this->faker->dateTimeBetween('now', '+1 month'),
            'end_date' => $this->faker->dateTimeBetween('+1 month', '+2 months'),
        ];
    }
}
