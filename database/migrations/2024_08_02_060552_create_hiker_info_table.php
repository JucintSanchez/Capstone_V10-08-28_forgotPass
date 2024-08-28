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
        Schema::create('hiker_info', function (Blueprint $table) {
            $table->bigInteger('hiker_id', true);
            $table->string('last_name', 20)->nullable();
            $table->string('first_name', 20)->nullable();
            $table->string('email', 50)->nullable();
            $table->integer('age')->nullable();
            $table->string('contact_num', 11)->nullable();
            $table->string('username', 20)->nullable();
            $table->string('password', 200)->nullable();
            $table->bigInteger('org_id')->nullable()->index('org_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hiker_info');
    }
};
