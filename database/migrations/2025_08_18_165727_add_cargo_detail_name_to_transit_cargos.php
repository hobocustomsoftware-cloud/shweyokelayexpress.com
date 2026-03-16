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
            $table->string('cargo_detail_name')->nullable();
            $table->string('notice_message')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transit_cargos', function (Blueprint $table) {
            $table->dropColumn('cargo_detail_name');
            $table->dropColumn('notice_message');
        });
    }
};
