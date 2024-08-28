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
        Schema::create('time_out', function (Blueprint $table) {
            $table->bigInteger('out_id', true);
            $table->time('time')->nullable();
            $table->bigInteger('hiker_id')->nullable()->index('hiker_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('time_out');
    }
};
