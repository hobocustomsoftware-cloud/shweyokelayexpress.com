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
        Schema::create('agent_users', function (Blueprint $table) {
            $table->id();
            $table->string('name_en', 50);
            $table->string('name_mm', 50);
            $table->string('phone', 11);
            $table->string('address', 100);
            $table->string('nrc', 20);
            $table->boolean('is_vip')->default(false);
            $table->string('commission', 10);
            $table->double('deposit', 10);
            $table->double('credit', 10);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agent_users');
    }
};
