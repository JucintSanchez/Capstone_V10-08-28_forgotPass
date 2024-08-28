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
        Schema::table('time_out', function (Blueprint $table) {
            $table->foreign(['hiker_id'], 'time_out_ibfk_1')->references(['hiker_id'])->on('hiker_info')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('time_out', function (Blueprint $table) {
            $table->dropForeign('time_out_ibfk_1');
        });
    }
};
