<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Conference;
use App\Models\Room;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Presentation>
 */
class PresentationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->name(),
            'description' => $this->faker->paragraph,
            'photo' => $this->faker->imageUrl(),
            'logo' => $this->faker->imageUrl(),
            'start_time' => $this->faker->dateTime(),
            'end_time' => $this->faker->dateTime(),
            'conference_id' => Conference::factory(),
            'room_id' => Room::factory(),
            'user_id' => User::inRandomOrder()->first()->id,
        ];
    }

    public function usingExistingConferenceAndRoom()
    {
        return $this->state(function (array $attributes) {
            return [
                'conference_id' => Conference::inRandomOrder()->first()->id,
                'room_id' => Room::inRandomOrder()->first()->id,
            ];
        });
    }
}
