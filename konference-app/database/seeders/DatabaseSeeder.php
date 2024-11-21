<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        $this->call([
            DeleteSeedsSeeder::class,
        ]);

        $this->call([
            UserSeeder::class,
            RoomSeeder::class,
            ConferenceSeeder::class,
            ReservationSeeder::class,
            PresentationSeeder::class,
            ConferenceRoomSeeder::class,
            // TO DO: add QuestionSeeder
        ]);
    }
}
