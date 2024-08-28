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
        Schema::table('system_notif', function (Blueprint $table) {
            $table->foreign(['hiker_id'], 'system_notif_ibfk_1')->references(['hiker_id'])->on('hiker_info')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('system_notif', function (Blueprint $table) {
            $table->dropForeign('system_notif_ibfk_1');
        });
    }
};
