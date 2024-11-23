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
            'equipment' => Room::factory()->make()->equipment,
        ]);

        Room::factory()->create([
            'name' => 'Conference Room A',
            'equipment' => Room::factory()->make()->equipment,
        ]);
        
        Room::factory()->create([
            'name' => 'Meeting Room 1',
            'equipment' => Room::factory()->make()->equipment,
        ]);
        
        Room::factory()->create([
            'name' => 'Workshop Area',
            'equipment' => Room::factory()->make()->equipment,
        ]);
        
        Room::factory()->create([
            'name' => 'Seminar Hall',
            'equipment' => Room::factory()->make()->equipment,
        ]);
        
        Room::factory()->create([
            'name' => 'Breakout Room',
            'equipment' => Room::factory()->make()->equipment,
        ]);
        
        Room::factory()->create([
            'name' => 'Training Room',
            'equipment' => Room::factory()->make()->equipment,
        ]);
        
        Room::factory()->create([
            'name' => 'Discussion Room',
            'equipment' => Room::factory()->make()->equipment,
        ]);
        
        Room::factory()->create([
            'name' => 'Lecture Hall',
            'equipment' => Room::factory()->make()->equipment,
        ]);
        
        Room::factory()->create([
            'name' => 'Board Room',
            'equipment' => Room::factory()->make()->equipment,
        ]);        
    }
}
