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
        Schema::table('payment_status', function (Blueprint $table) {
            $table->foreign(['hiker_id'], 'payment_status_ibfk_1')->references(['hiker_id'])->on('hiker_info')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payment_status', function (Blueprint $table) {
            $table->dropForeign('payment_status_ibfk_1');
        });
    }
};
