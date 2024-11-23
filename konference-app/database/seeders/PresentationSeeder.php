<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Presentation;

class PresentationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Presentation::factory()->create([
            'title' => 'Laravel presentation',
            'description' => 'News about Laravel',
            'start_time' => '2022-02-02 00:00:00',
            'end_time' => '2022-02-02 18:00:00',
            'conference_id' => 1,
            'room_id' => 1,
            'user_id' => 2,
            'status' => 'approved'
        ]);
        Presentation::factory()->create([
            'title' => 'Advanced PHP Techniques',
            'description' => 'A presentation on advanced PHP techniques.',
            'start_time' => '2024-11-02 11:00:00',
            'end_time' => '2024-11-02 12:00:00',
            'conference_id' => 2, 
            'room_id' => 2, 
            'user_id' => 3, 
            'status' => 'pending',
        ]);
        Presentation::factory()->create([
            'title' => 'Advanced PHP Techniques',
            'description' => 'A presentation on advanced PHP techniques.',
            'start_time' => '2024-11-24 11:00:00',
            'end_time' => '2024-11-24 12:00:00',
            'conference_id' => 2, 
            'room_id' => 2, 
            'user_id' => 1, 
            'status' => 'approved',
        ]);
        Presentation::factory()->create([
            'title' => 'Advanced PHP Techniques',
            'description' => 'A presentation on advanced PHP techniques.',
            'end_time' => '2024-11-24 13:00:00',
            'conference_id' => 2, 
            'room_id' => 2, 
            'user_id' => 2, 
            'status' => 'approved',
        ]);
        Presentation::factory()->create([
            'title' => 'Advanced PHP Techniques',
            'description' => 'A presentation on advanced PHP techniques.',
            'start_time' => '2024-11-24 13:00:00',
            'end_time' => '2024-11-24 14:00:00',
            'conference_id' => 2, 
            'room_id' => 2, 
            'user_id' => 3, 
            'status' => 'approved',
        ]);
        Presentation::factory()->create([
            'title' => 'Advanced PHP Techniques',
            'description' => 'A presentation on advanced PHP techniques.',
            'start_time' => '2024-11-23 13:00:00',
            'end_time' => '2024-11-23 14:00:00',
            'conference_id' => 2, 
            'room_id' => 2, 
            'user_id' => 3, 
            'status' => 'approved',
        ]);
        Presentation::factory()->create([
            'title' => 'Advanced PHP Techniques',
            'description' => 'A presentation on advanced PHP techniques.',
            'start_time' => '2024-11-22 13:00:00',
            'end_time' => '2024-11-22 14:00:00',
            'conference_id' => 2, 
            'room_id' => 2, 
            'user_id' => 3, 
            'status' => 'approved',
        ]);
        
        
        Presentation::factory()->usingExistingConferenceAndRoom()->count(200)->create();
    }
}
