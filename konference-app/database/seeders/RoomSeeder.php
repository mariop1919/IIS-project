<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Room::factory()->create([
            'name' => 'Main hall',
            'capacity' => 100,
            'equipment' => 1,
        ]);
        Room::factory()->count(9)->create();
    }
}
