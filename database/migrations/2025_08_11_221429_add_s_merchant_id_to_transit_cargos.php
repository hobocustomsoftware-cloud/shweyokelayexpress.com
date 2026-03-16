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
            $table->unsignedBigInteger('s_merchant_id')->nullable();
            $table->foreign('s_merchant_id')->references('id')->on('merchants')->onDelete('cascade');
            $table->unsignedBigInteger('r_merchant_id')->nullable();
            $table->foreign('r_merchant_id')->references('id')->on('merchants')->onDelete('cascade');
            $table->string('s_name_string')->nullable();
            $table->string('r_name_string')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transit_cargos', function (Blueprint $table) {
            $table->dropForeign(['s_merchant_id']);
            $table->dropForeign(['r_merchant_id']);
            $table->dropColumn('s_merchant_id');
            $table->dropColumn('r_merchant_id');
            $table->dropColumn('s_name_string');
            $table->dropColumn('r_name_string');
        });
    }
};
