<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
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
            'name' => fake()->randomElement(['Living Room', 'Kitchen', 'Bedroom', 'Bathroom', 'Garage', 'Basement', 'Attic', 'Office']),
            'location' => fake()->optional()->randomElement(['First Floor', 'Second Floor', 'Basement', 'Ground Level']),
            'description' => fake()->optional()->sentence(),
        ];
    }
}
