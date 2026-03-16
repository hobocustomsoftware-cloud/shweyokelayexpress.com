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
            $table->renameColumn('from_city_id', 'from_city');
            $table->renameColumn('to_city_id', 'to_city');
            $table->renameColumn('from_gate_id', 'from_gate');
            $table->renameColumn('to_gate_id', 'to_gate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transit_cargos', function (Blueprint $table) {
            $table->renameColumn('from_city', 'from_city_id');
            $table->renameColumn('to_city', 'to_city_id');
            $table->renameColumn('from_gate', 'from_gate_id');
            $table->renameColumn('to_gate', 'to_gate_id');
        });
    }
};
