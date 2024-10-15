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
            'role' => 'unregistered_user',
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
     * Indicate that the user is a registred user.
     *
     * @return $this
     */
    public function registred_user(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => 'registred_user',
            ];
        });
    }

    /**
     * Indicate that the user is an unregistred user.
     *
     * @return $this
     */
    public function unregistred_user(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => 'unregistred_user',
            ];
        });
    }
}
