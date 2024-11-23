<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeleteSeedsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('users')->truncate();
        DB::table('conferences')->truncate();
        DB::table('rooms')->truncate();
        DB::table('conference_room')->truncate();
        DB::table('reservations')->truncate();
        DB::table('presentations')->truncate();
        DB::table('questions')->truncate();
        DB::table('votes')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
