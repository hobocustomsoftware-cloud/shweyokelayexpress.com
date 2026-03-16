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
        Schema::table('transit_cargos', function (Blueprint $table) {
            $table->foreignId('car_id')->nullable()->constrained('cars')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transit_cargos', function (Blueprint $table) {
            $table->dropColumn('car_id');
        });
    }
};
