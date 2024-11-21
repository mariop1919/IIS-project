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
        return [
            'title' => $this->faker->name(),
            'description' => $this->faker->paragraph,
            'photo' => $this->getPicsumPhotoUrl(360, 360),
            'start_time' => $this->faker->dateTime(),
            'end_time' => $this->faker->dateTime(),
            'conference_id' => Conference::factory(),
            'room_id' => Room::factory(),
            'user_id' => $this->getExistingRecordId(User::class),
            'status' => 'pending',
        ];
    }

    private function getExistingRecordId(string $table): int
    {
        $record = $table::inRandomOrder()->first();

        if(!$record) {
            throw new Exception("No records found in the $table table, please create some records first.");
        }
        return $record->id;
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
    private function getPicsumPhotoUrl(int $width, int $height): string
    {
        return "https://picsum.photos/{$width}/{$height}";
    }
    
}
