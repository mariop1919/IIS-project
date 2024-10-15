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
            'name' => 'John Doe',
            'capacity' => 100,
            'equipment' => 'notebook',
        ]);
        User::factory()->count(9)->create();
    }
}
