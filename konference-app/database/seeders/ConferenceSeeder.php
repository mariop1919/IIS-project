<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Conference;

class ConferenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Conference::factory()->create([
            'name' => 'Laravel Conference',
            'description' => 'Conference about Laravel',
            'location' => 'Brno',
            'capacity' => 20,
            'price' => 22.22,
            'start_time' => '2024-11-27 16:00:00',
            'end_time' => '2024-11-29 18:00:00',
            'user_id' => 3, 
        ]);

        Conference::factory()->create([
            'name' => 'PHP Conference',
            'description' => 'Conference about PHP',
            'location' => 'Prague',
            'capacity' => 75,
            'price' => 30.00,
            'start_time' => '2024-12-01 11:00:00',
            'end_time' => '2024-12-02 18:30:00',
            'user_id' => 3, 
        ]);
        Conference::factory()->create([
            'name' => 'Example Conference',
            'description' => 'Conference about Example',
            'location' => 'Bratislava',
            'capacity' => 0,
            'price' => 50.00,
            'start_time' => '2024-11-27 14:00:00',
            'end_time' => '2024-11-29 18:30:00',
            'user_id' => 3, 
        ]);
        
        Conference::factory()->create([
            'name' => 'Conference 1',
            'description' => 'Conference about Conference',
            'location' => 'Brno',
            'capacity' => 50,
            'price' => 40.00,
            'start_time' => '2024-11-29 16:50:00',
            'end_time' => '2024-12-03 18:00:00',
            'user_id' => 1, 
        ]);

        Conference::factory()->create([
            'name' => 'IIS Conference',
            'description' => 'Conference about IIS',
            'location' => 'Brno',
            'capacity' => 50,
            'price' => 40.00,
            'start_time' => '2024-12-04 11:00:00',
            'end_time' => '2024-12-06 18:00:00',
            'user_id' => 1, 
        ]);
    }
}
