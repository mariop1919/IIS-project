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
            'capacity' => 100,
            'price' => 22.22,
            'user_id' => 3, 
        ]);

        Conference::factory()->create([
            'name' => 'PHP Conference',
            'description' => 'Conference about PHP',
            'location' => 'Prague',
            'capacity' => 200,
            'price' => 30.00,
            'user_id' => 3, 
        ]);
        Conference::factory()->create([
            'name' => 'Example Conference',
            'description' => 'Conference about Example',
            'location' => 'Bratislava',
            'capacity' => 0,
            'price' => 50.00,
            'user_id' => 3, 
        ]);
        
        // Conference::factory()->usingExistingUser()->count(4)->create();
    }
}
