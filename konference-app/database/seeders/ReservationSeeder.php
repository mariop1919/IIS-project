<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reservation;
use Exception;

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
            'is_paid' => true,
            'user_id' => 4,
        ]);

        Reservation::factory()->create([
            'name' => 'Jane Doe',
            'email' => 'janedoe@example.com',
            'phone' => '987-654-321',
            'conference_id' => 2, 
            'is_paid' => false,
            'user_id' => 5, 
        ]);
        Reservation::factory()->create([
            'name' => 'Kira Morton',
            'email' => 'kiramorton@example.com',
            'phone' => '987-654-321',
            'conference_id' => 2,
            'is_paid' => true,
            'user_id' => 3,
        ]);
        Reservation::factory()->create([
            'name' => 'Rehan Oneill',
            'email' => 'rehanoneill@example.com',
            'phone' => '987-654-321',
            'conference_id' => 1, 
            'is_paid' => false,
            'user_id' => 3, 
        ]);
        Reservation::factory()->create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'phone' => '987-654-321',
            'conference_id' => 1, 
            'is_paid' => true,
            'user_id' => 1, 
        ]);

        $this->createReservationsWithCapacityCheck(75);
    }


    private function createReservationsWithCapacityCheck(int $count): void
    {
        for ($i = 0; $i < $count; $i++) {
            try {
                Reservation::factory()->usingExistingUserAndConference()->create();
            } catch (Exception $e) {
                break;
            }
        }
    }
}
