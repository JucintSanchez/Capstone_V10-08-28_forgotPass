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
        Schema::create('guide_info', function (Blueprint $table) {
            $table->bigInteger('guide_id', true);
            $table->string('last_name', 30)->nullable();
            $table->string('first_name', 30)->nullable();
            $table->string('address', 200)->nullable();
            $table->string('email', 50)->nullable();
            $table->string('contact_num', 11)->nullable();
            $table->string('proof', 250)->nullable();
            $table->string('status', 20)->nullable();
            $table->string('username', 20)->nullable();
            $table->string('password', 150)->nullable();
            $table->bigInteger('org_id')->nullable()->index('org_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guide_info');
    }
};
