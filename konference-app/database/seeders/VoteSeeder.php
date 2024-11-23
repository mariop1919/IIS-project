<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vote;
use App\Models\User;
use App\Models\Presentation;

class VoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $approvedPresentations = Presentation::where('status', 'approved')->get();

        // Check if there are enough approved presentations (at least 8)
        if ($approvedPresentations->count() >= 4) {
            // Manually create votes for the first 8 approved presentations and assign users
            Vote::create([
                'presentation_id' => $approvedPresentations[0]->id,
                'user_id' => 1, // Replace with an actual user ID
            ]);

            Vote::create([
                'presentation_id' => $approvedPresentations[1]->id,
                'user_id' => 2,
            ]);

            Vote::create([
                'presentation_id' => $approvedPresentations[2]->id,
                'user_id' => 3,
            ]);

            Vote::create([
                'presentation_id' => $approvedPresentations[3]->id,
                'user_id' => 4,
            ]);
        }
    }
}