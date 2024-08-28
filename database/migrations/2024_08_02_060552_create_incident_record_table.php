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
        Schema::create('incident_record', function (Blueprint $table) {
            $table->bigInteger('incident_id', true);
            $table->string('desc')->nullable();
            $table->string('reported_by', 100)->nullable();
            $table->bigInteger('guide_id')->nullable()->index('guide_id');
            $table->bigInteger('hiker_id')->nullable()->index('hiker_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incident_record');
    }
};
