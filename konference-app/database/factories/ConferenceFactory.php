<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Conference>
 */
class ConferenceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startTime = $this->faker->dateTimeBetween('now', '+2weeks');
        $endTime = (clone $startTime)->modify('+'.rand(4, 48).' hours');
        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->text(),
            'location' => $this->faker->address(),
            'capacity' => $this->faker->numberBetween(1, 100),
            'price' => $this->faker->randomFloat(2, 0, 100000),
            'start_time' => $startTime,
            'end_time' => $endTime,
            'user_id' => User::factory(),
        ];
    }

    public function usingExistingUser()
    {
        return $this->state(function (array $attributes) {
            return [
                'user_id' => User::inRandomOrder()->first()->id,
            ];
        });
    }
}
