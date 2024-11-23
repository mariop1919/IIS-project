<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {   
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'is_activated' => true,
            ]);
        User::factory()->create([
            'name' => 'Kira Morton',
            'email' => 'speaker@example.com',
            'password' => bcrypt('password'),
            'role' => 'speaker',
            'is_activated' => true,
        ]);
        User::factory()->create([
            'name' => 'Rehan Oneill',
            'email' => 'organizer@example.com',
            'password' => bcrypt('password'),
            'role' => 'organizer',
            'is_activated' => true,
        ]);

        User::factory()->create([
            'name' => 'John Doe',
            'email' => 'guest1@example.com',
            'password' => bcrypt('password'),
            'role' => 'guest',
            'is_activated' => true,
        ]);
        User::factory()->create([
            'name' => 'Jane Doe',
            'email' => 'guest2@example.com',
            'password' => bcrypt('password'),
            'role' => 'guest',
            'is_activated' => false,
        ]);
    }
}
