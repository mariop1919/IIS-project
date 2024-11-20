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
            'name' => 'Main Hall',
            'capacity' => 200,
            'equipment' => 'Projector, Speakers',
        ]);

        Room::factory()->create([
            'name' => 'Conference Room A',
            'capacity' => 100,
            'equipment' => 'Whiteboard, Laptop',
        ]);
        
        // Room::factory()->count(4)->create();
    }
}
