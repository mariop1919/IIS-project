<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Conference;
use App\Models\Room;
use Exception;

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
        $conference = Conference::inRandomOrder()->first();

        // Find a room that hasn't been used for this conference yet
        $usedRoomIds = $conference->rooms->pluck('id')->toArray(); // Adjust based on your relationship setup
        $room = Room::whereNotIn('id', $usedRoomIds)->inRandomOrder()->first();

        if (!$room) {
            throw new Exception('No available rooms for this conference.');
        }

        return [
            'conference_id' => $conference->id,
            'room_id' => $room->id,
            'start_time' => $conference->start_time,
            'end_time' => $conference->end_time,
        ];
    });
}

}
