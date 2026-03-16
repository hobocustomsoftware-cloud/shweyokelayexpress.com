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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('number')->unique();
            $table->date('departure_date');
            $table->string('driver_name')->nullable();
            $table->string('driver_phone_number')->nullable();
            $table->string('assistant_driver_name')->nullable();
            $table->string('assistant_driver_phone')->nullable();
            $table->string('spare_name')->nullable();
            $table->string('spare_phone')->nullable();
            $table->string('assistant_spare_name')->nullable();
            $table->string('assistant_spare_phone')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
