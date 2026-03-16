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
        Schema::table('cars', function (Blueprint $table) {
            if (Schema::hasColumn('cars', 'departure_time')) {
                $table->dropColumn('departure_time');
            }
            if (Schema::hasColumn('cars', 'arrival_date')) {
                $table->dropColumn('arrival_date');
            }
            if (Schema::hasColumn('cars', 'arrival_time')) {
                $table->dropColumn('arrival_time');
            }
            if (Schema::hasColumn('cars', 'pass_through_gate_name')) {
                $table->dropColumn('pass_through_gate_name');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            if (!Schema::hasColumn('cars', 'departure_time')) {
                $table->time('departure_time')->nullable();
            }
            if (!Schema::hasColumn('cars', 'arrival_date')) {
                $table->date('arrival_date');
            }
            if (!Schema::hasColumn('cars', 'arrival_time')) {
                $table->time('arrival_time')->nullable();
            }
            if (!Schema::hasColumn('cars', 'pass_through_gate_name')) {
                $table->string('pass_through_gate_name');
            }
        });
    }
};
