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
            $table->dropForeign(['cargo_type_id']);

            $table->foreign('cargo_type_id')
                ->references('id')->on('cargo_types')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cargos', function (Blueprint $table) {
            $table->dropForeign(['cargo_type_id']);

            $table->foreign('cargo_type_id')
                ->references('id')->on('cargo_types')
                ->onDelete('cascade');
        });
    }
};
