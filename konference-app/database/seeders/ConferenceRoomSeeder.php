<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ConferenceRoom;
use Database\Factories\ConferenceRoomFactory;

class ConferenceRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ConferenceRoom::factory()->usingExistingConferenceAndRoom()->count(10)->create();
    }
}
