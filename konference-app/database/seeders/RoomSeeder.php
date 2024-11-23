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
            'equipment' => 'Projector, Speakers',
        ]);

        Room::factory()->create([
            'name' => 'Conference Room A',
            'equipment' => 'Whiteboard, Laptop',
        ]);
        
        Room::factory()->count(10)->create();
    }
}
