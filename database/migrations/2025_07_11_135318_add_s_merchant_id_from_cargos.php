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
            $table->unsignedBigInteger('s_merchant_id')->nullable();
            $table->foreign('s_merchant_id')->references('id')->on('merchants')->onDelete('cascade');
            $table->unsignedBigInteger('r_merchant_id')->nullable();
            $table->foreign('r_merchant_id')->references('id')->on('merchants')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cargos', function (Blueprint $table) {
            $table->dropForeign(['s_merchant_id']);
            $table->dropForeign(['r_merchant_id']);
            $table->dropColumn(['s_merchant_id', 'r_merchant_id']);
        });
    }
};
