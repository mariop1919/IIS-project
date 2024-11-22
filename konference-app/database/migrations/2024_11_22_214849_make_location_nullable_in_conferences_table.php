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
        $table->string('location')->nullable()->change();
    });
}

public function down()
{
    Schema::table('conferences', function (Blueprint $table) {
        $table->string('location')->nullable(false)->change();
    });
}
};
