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
        Schema::create('pax_member', function (Blueprint $table) {
            $table->bigInteger('pax_member_ID', true);
            $table->string('member_name', 100)->nullable();
            $table->integer('age')->nullable();
            $table->string('gender', 10)->nullable();
            $table->bigInteger('pax_info_id')->nullable()->index('pax_info_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pax_member');
    }
};
