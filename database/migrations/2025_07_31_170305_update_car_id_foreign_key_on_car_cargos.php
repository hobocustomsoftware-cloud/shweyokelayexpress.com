<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('cargos', function (Blueprint $table) {
            $table->foreignId('car_id')
                ->nullable()
                ->constrained('cars')
                ->cascadeOnDelete()->change();
            $table->foreignId('cargo_id')
                ->nullable()
                ->constrained('cargos')
                ->cascadeOnDelete()->change();
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->cascadeOnDelete()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cargos', function (Blueprint $table) {
            $table->foreignId('car_id')
                ->constrained('cars')
                ->cascadeOnDelete()->change();
            $table->foreignId('cargo_id')->constrained('cargos')->cascadeOnDelete()->change();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->change();
        });
    }
};
