<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ConferenceRoom;
use Database\Factories\ConferenceRoomFactory;

class ConferenceRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ConferenceRoom::create([
            'conference_id' => 1,   
            'room_id' => 1,         
            'start_time' => '2024-11-01 09:00:00',  
            'end_time' => '2024-11-01 11:00:00', 
        ]);
        ConferenceRoom::create([
            'conference_id' => 2,   
            'room_id' => 2,         
            'start_time' => '2024-11-01 09:00:00',  
            'end_time' => '2024-11-01 11:00:00', 
        ]);
        
        // ConferenceRoom::factory()->usingExistingConferenceAndRoom()->count(4)->create();
    }
}
