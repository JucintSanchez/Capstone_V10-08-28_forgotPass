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
        Schema::table('guide_info', function (Blueprint $table) {
            $table->foreign(['org_id'], 'guide_info_ibfk_1')->references(['org_id'])->on('organization')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('guide_info', function (Blueprint $table) {
            $table->dropForeign('guide_info_ibfk_1');
        });
    }
};
