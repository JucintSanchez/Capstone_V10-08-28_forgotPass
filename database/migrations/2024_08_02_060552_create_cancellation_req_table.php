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
        Schema::create('cancellation_req', function (Blueprint $table) {
            $table->bigInteger('cancellation_id', true);
            $table->string('reason', 1000)->nullable();
            $table->string('status', 20)->nullable();
            $table->bigInteger('pax_info_id')->nullable()->index('pax_info_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cancellation_req');
    }
};
