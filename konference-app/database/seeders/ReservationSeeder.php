<?php

namespace Database\Seeders;

use App\Models\Reservation;
use Illuminate\Database\Seeder;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Reservation::factory()->create([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'phone' => '123-456-789',
            'conference_id' => 1,
            'is_paid' => 1,
            'user_id' => 1,
        ]);
        Reservation::factory()->count(4)->create();
    }
}
