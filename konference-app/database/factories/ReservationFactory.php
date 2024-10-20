<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Conference;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'is_paid' => $this->faker->boolean(),
            'user_id' => User::factory(),
            'conference_id' => Conference::factory(),
        ];
    }

    public function usingExistingUserAndConference()
    {
        return $this->state(function (array $attributes) {
            return [
                'user_id' => User::inRandomOrder()->first()->id,
                'conference_id' => Conference::inRandomOrder()->first()->id,
            ];
        });
    }
}
