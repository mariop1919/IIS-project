<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Conference;
use App\Models\Room;
use App\Models\User;
use Exception;

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

        //get a random conference
        $conference = Conference::inRandomOrder()->first();

        // Ensure that the start and end time of the presentation are within the conference times
        $startTime = $this->faker->dateTimeBetween($conference->start_time, $conference->end_time);
        
        $maxEndTime = $conference->end_time;
        $endTime = $this->faker->dateTimeBetween($startTime, $maxEndTime);

        $uniqueIndex = $this->faker->unique()->numberBetween(1, 100);
        $photoUrl = $this->getStaticPicsumPhotoUrl($uniqueIndex);

        // already uses existing conference, room and user
        return [
            'title' => $this->faker->name(),
            'description' => $this->faker->paragraph,
            'photo' => $photoUrl,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'conference_id' => $conference->id,
            'room_id' => Room::inRandomOrder()->first()->id,
            'user_id' => User::inRandomOrder()->first()->id,
            'status' => $this->faker->boolean ? 'approved' : 'pending',
        ];
    }

    private function getStaticPicsumPhotoUrl(int $index): string
    {
        return "https://picsum.photos/360/360?image={$index}";
    }
}
