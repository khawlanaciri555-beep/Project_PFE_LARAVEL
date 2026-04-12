<?php

namespace Database\Factories;

use App\Models\Cooperative;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Cooperative>
 */
class CooperativeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->safeEmail(),
            'address' => $this->faker->address(),
            'image' => $this->faker->imageUrl(),
            'description' => $this->faker->sentence(),
            'user_id' => \App\Models\User::factory(),
            'availability' => true,
            'is_deleted' => false,
        ];
    }
}
