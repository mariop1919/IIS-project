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
            ]);
        User::factory()->create([
            'name' => 'Kira Morton',
            'email' => 'kiramorton@example.com',
            'password' => bcrypt('password'),
            'role' => 'speaker',
        ]);
        User::factory()->create([
            'name' => 'Rehan Oneill',
            'email' => 'rehanoneill@example.com',
            'password' => bcrypt('password'),
            'role' => 'organizer',
        ]);

        User::factory()->create([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => bcrypt('password'),
            'role' => 'guest',
        ]);
        User::factory()->create([
            'name' => 'Jane Doe',
            'email' => 'janedoe@example.com',
            'password' => bcrypt('password'),
            'role' => 'guest',
        ]);

    }
}
