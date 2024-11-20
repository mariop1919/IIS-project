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
            'name' => $this->faker->word(),  // A single word as room name
            'equipment' => implode(', ', $this->faker->randomElements([  // Randomly selected equipment
                'Projector',
                'Speakers',
                'Whiteboard',
                'Laptop'
            ], $count = rand(1, 2))),  // Select 1 to 4 random items
        ];
    }
}
