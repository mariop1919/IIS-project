<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        $this->call([
            ConferenceSeeder::class,
            PresentationSeeder::class,
            ReservationSeeder::class,
            RoomSeeder::class,
            UserSeeder::class,
        ]);
    }
}
