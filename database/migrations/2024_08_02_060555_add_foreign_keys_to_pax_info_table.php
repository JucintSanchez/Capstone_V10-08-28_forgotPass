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
        Schema::table('pax_info', function (Blueprint $table) {
            $table->foreign(['guide_id'], 'pax_info_ibfk_1')->references(['guide_id'])->on('guide_info')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['hiker_id'], 'pax_info_ibfk_2')->references(['hiker_id'])->on('hiker_info')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['act_id'], 'pax_info_ibfk_3')->references(['activity_id'])->on('activity_logs')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pax_info', function (Blueprint $table) {
            $table->dropForeign('pax_info_ibfk_1');
            $table->dropForeign('pax_info_ibfk_2');
            $table->dropForeign('pax_info_ibfk_3');
        });
    }
};
