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
        Schema::table('hiker_info', function (Blueprint $table) {
            $table->foreign(['org_id'], 'hiker_info_ibfk_1')->references(['org_id'])->on('organization')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hiker_info', function (Blueprint $table) {
            $table->dropForeign('hiker_info_ibfk_1');
        });
    }
};
