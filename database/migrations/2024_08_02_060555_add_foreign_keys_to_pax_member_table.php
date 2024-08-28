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
        Schema::table('pax_member', function (Blueprint $table) {
            $table->foreign(['pax_info_id'], 'pax_member_ibfk_1')->references(['pax_id'])->on('pax_info')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pax_member', function (Blueprint $table) {
            $table->dropForeign('pax_member_ibfk_1');
        });
    }
};
