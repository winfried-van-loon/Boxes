<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Box>
 */
class BoxFactory extends Factory
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
            'name' => fake()->words(3, true),
            'number' => 'B-' . fake()->unique()->numberBetween(1000, 9999),
            'type' => fake()->randomElement(['Small Cardboard', 'Medium Cardboard', 'Large Cardboard', 'Plastic Bin', 'Wooden Crate']),
            'current_location' => fake()->optional()->words(2, true),
            'target_location' => fake()->optional()->words(2, true),
            'description' => fake()->optional()->sentence(),
        ];
    }
}
