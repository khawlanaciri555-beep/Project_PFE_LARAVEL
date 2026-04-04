<?php

namespace Database\Factories;

use App\Models\PlanningItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PlanningItem>
 */
class PlanningItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'planning_id' => \App\Models\Planning::factory(),
            'place_id' => \App\Models\Place::factory(),
            'time' => $this->faker->time(),
        ];
    }
}
