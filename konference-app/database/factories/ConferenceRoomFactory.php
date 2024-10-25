<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Conference;
use App\Models\Room;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ConferenceRoom>
 */
class ConferenceRoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'conference_id' => Conference::factory(),
            'room_id' => Room::factory(),
            'start_time' => $this->faker->dateTime(),
            'end_time' => $this->faker->dateTime(),
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
