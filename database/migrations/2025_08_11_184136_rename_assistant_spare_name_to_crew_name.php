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
            $table->renameColumn('assistant_spare_name', 'crew_name');
            $table->renameColumn('assistant_spare_phone', 'crew_phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->renameColumn('crew_name', 'assistant_spare_name');
            $table->renameColumn('crew_phone', 'assistant_spare_phone');
        });
    }
};
