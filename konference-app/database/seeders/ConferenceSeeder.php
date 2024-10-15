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
            'user_id' => 1,
        ]);

        Conference::factory()->count(9)->create();

    }
}
