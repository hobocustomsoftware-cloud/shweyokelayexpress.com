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
            if (!Schema::hasColumn('cars', 'assistant_driver_name')) {
                $table->string('assistant_driver_name')->nullable();
            }
            if (!Schema::hasColumn('cars', 'assistant_driver_phone')) {
                $table->string('assistant_driver_phone')->nullable();
            }
            if (!Schema::hasColumn('cars', 'spare_name')) {
                $table->string('spare_name')->nullable();
            }
            if (!Schema::hasColumn('cars', 'spare_phone')) {
                $table->string('spare_phone')->nullable();
            }
            if (!Schema::hasColumn('cars', 'assistant_spare_name')) {
                $table->string('assistant_spare_name')->nullable();
            }
            if (!Schema::hasColumn('cars', 'assistant_spare_phone')) {
                $table->string('assistant_spare_phone')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            if (Schema::hasColumn('cars', 'assistant_driver_name')) {
                $table->dropColumn('assistant_driver_name');
            }
            if (Schema::hasColumn('cars', 'assistant_driver_phone')) {
                $table->dropColumn('assistant_driver_phone');
            }
            if (Schema::hasColumn('cars', 'spare_name')) {
                $table->dropColumn('spare_name');
            }
            if (Schema::hasColumn('cars', 'spare_phone')) {
                $table->dropColumn('spare_phone');
            }
            if (Schema::hasColumn('cars', 'assistant_spare_name')) {
                $table->dropColumn('assistant_spare_name');
            }
            if (Schema::hasColumn('cars', 'assistant_spare_phone')) {
                $table->dropColumn('assistant_spare_phone');
            }
        });
    }
};
