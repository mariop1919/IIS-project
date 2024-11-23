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
            ConferenceSeeder::class,
            RoomSeeder::class,
            ConferenceRoomSeeder::class,
            ReservationSeeder::class,
            PresentationSeeder::class,
            QuestionSeeder::class,
        ]);
    }
}
