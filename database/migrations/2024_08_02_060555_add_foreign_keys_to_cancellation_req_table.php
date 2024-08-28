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
        Schema::table('cancellation_req', function (Blueprint $table) {
            $table->foreign(['pax_info_id'], 'cancellation_req_ibfk_1')->references(['pax_id'])->on('pax_info')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cancellation_req', function (Blueprint $table) {
            $table->dropForeign('cancellation_req_ibfk_1');
        });
    }
};
