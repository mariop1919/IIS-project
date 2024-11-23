<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Conference;
use App\Models\Reservation;
use Exception;

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
            'user_id' => $this->getExistingRecordId(User::class),
            'conference_id' => $this->getAvailableConferenceId(),
        ];
    }

    private function getExistingRecordId(string $table): int
    {
        $record = $table::inRandomOrder()->first();

        if (!$record) {
            throw new Exception("No records found in the $table table, please create some records first.");
        }
        return $record->id;
    }

    private function getAvailableConferenceId(): int
    {
        $conferences = Conference::withCount('reservations')
            ->get()
            ->filter(function ($conference) {
                return $conference->capacity > $conference->reservations_count;
            });

        if ($conferences->isEmpty()) {
            throw new Exception("No available conferences found with capacity.");
        }

        return $conferences->random()->id;
    }

    public function usingExistingUserAndConference()
    {
        return $this->state(function (array $attributes) {
            return [
                'user_id' => $this->getExistingRecordId(User::class),
                'conference_id' => $this->getAvailableConferenceId(),
            ];
        });
    }
}
