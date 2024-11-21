<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'role' => null,
            'is_activated' => true,
        ];
    }

    /**
     * Indicate that the user is an admin.
     *
     * @return $this
     */
    public function admin(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => 'admin',
            ];
        });
    }

    /**
     * Indicate that the user is an organizer.
     *
     * @return $this
     */
    public function organizer(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => 'organizer',
            ];
        });
    }

    /**
     * Indicate that the user is a speaker.
     *
     * @return $this
     */
    public function speaker(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => 'speaker',
            ];
        });
    }

    /**
     * Indicate that the user is a guest.
     *
     * @return $this
     */
    public function guest(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => 'guest',
            ];
        });
    }
}
