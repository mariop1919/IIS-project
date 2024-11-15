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
                'user_id' => 1,
                'status' => 'approved'
        ]);
        
        Presentation::factory()->usingExistingConferenceAndRoom()->count(4)->create();
    }
}
