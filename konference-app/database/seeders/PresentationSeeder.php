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
            'photo' => 'example.jpg',
            'logo' => 'exampleLogo.jpg',  
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
            'photo' => 'php.jpg',
            'logo' => 'php_logo.png',
            'start_time' => '2024-11-02 11:00:00',
            'end_time' => '2024-11-02 12:00:00',
            'conference_id' => 2, 
            'room_id' => 2, 
            'user_id' => 3, 
            'status' => 'pending',
        ]);
        
        // Presentation::factory()->usingExistingConferenceAndRoom()->count(4)->create();
    }
}
