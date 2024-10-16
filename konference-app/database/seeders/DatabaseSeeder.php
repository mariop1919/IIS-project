<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            RoomSeeder::class,
            ConferenceSeeder::class,
            ReservationSeeder::class,
            PresentationSeeder::class,
            ConferenceRoomSeeder::class,
        ]);
    }
}
