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
            // Fetch an existing conference and room
            $conference = Conference::inRandomOrder()->first();
            $room = Room::inRandomOrder()->first();

            // Use the exact start and end times of the conference
            return [
                'conference_id' => $conference->id,
                'room_id' => $room->id,
                'start_time' => $conference->start_time,
                'end_time' => $conference->end_time,
            ];
        });
    }
}
