<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Step 1: Drop the index on the `room_id` column
        Schema::table('presentations', function (Blueprint $table) {
            // Drop index for room_id
            $table->dropIndex('presentations_room_id_foreign');
        });

        // Step 2: Alter the `room_id` column to be nullable
        Schema::table('presentations', function (Blueprint $table) {
            $table->bigInteger('room_id')->unsigned()->nullable()->change();
        });

        // Step 3: Re-add the foreign key constraint
        Schema::table('presentations', function (Blueprint $table) {
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Step 1: Drop the foreign key constraint on `room_id`
        Schema::table('presentations', function (Blueprint $table) {
            $table->dropForeign(['room_id']);
        });

        // Step 2: Alter the `room_id` column to not nullable
        Schema::table('presentations', function (Blueprint $table) {
            $table->bigInteger('room_id')->unsigned()->change();
        });

        // Step 3: Re-add the index on `room_id`
        Schema::table('presentations', function (Blueprint $table) {
            $table->index('room_id');
        });
    }
};
