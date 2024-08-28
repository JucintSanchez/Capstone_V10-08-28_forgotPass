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
        Schema::table('tourist_spot', function (Blueprint $table) {
            $table->foreign(['org_id'], 'tourist_spot_ibfk_1')->references(['org_id'])->on('organization')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tourist_spot', function (Blueprint $table) {
            $table->dropForeign('tourist_spot_ibfk_1');
        });
    }
};
