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
        Schema::create('pax_info', function (Blueprint $table) {
            $table->bigInteger('pax_id', true);
            $table->string('pax_name', 20)->nullable();
            $table->integer('pax_count')->nullable();
            $table->date('hike_date')->nullable();
            $table->string('status', 50)->nullable();
            $table->bigInteger('guide_id')->nullable()->index('guide_id');
            $table->bigInteger('hiker_id')->nullable()->index('hiker_id');
            $table->bigInteger('act_id')->nullable()->index('act_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pax_info');
    }
};
