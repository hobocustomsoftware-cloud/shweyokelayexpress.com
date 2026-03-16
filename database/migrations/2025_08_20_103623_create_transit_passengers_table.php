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
        Schema::create('transit_passengers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('phone', 20);
            $table->string('address', 100)->nullable();
            $table->string('nrc', 20)->nullable();
            $table->foreignId('car_id')->nullable()->constrained('cars')->onDelete('cascade');
            $table->string('seat_number', 10)->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->foreignId('transit_cargo_id')->nullable()->constrained('transit_cargos')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('voucher_number', 20)->nullable();
            $table->boolean('is_paid')->default(false);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transit_passengers');
    }
};
