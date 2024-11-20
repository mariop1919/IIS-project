<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('conferences', function (Blueprint $table) {
            $table->dateTime('start_time')->nullable();  // Add start_time column
            $table->dateTime('end_time')->nullable();    // Add end_time column
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('conferences', function (Blueprint $table) {
            $table->dropColumn(['start_time', 'end_time']);
        });
    }
};
