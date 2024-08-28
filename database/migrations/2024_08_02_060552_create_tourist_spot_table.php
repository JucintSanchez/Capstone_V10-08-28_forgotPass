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
        Schema::create('tourist_spot', function (Blueprint $table) {
            $table->bigInteger('tourist_spot_ID', true);
            $table->text('desc')->nullable();
            $table->binary('images')->nullable();
            $table->bigInteger('org_id')->nullable()->index('org_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tourist_spot');
    }
};
