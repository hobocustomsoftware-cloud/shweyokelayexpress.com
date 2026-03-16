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
        Schema::table('cargos', function (Blueprint $table) {
            $table->string('s_name_string', 100)->nullable()->change();
            $table->string('r_name_string', 100)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cargos', function (Blueprint $table) {
            $table->string('s_name_string', 100)->change();
            $table->string('r_name_string', 100)->change();
        });
    }
};
