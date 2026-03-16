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
            $table->dropColumn('route');
            $table->string('from')->comment('မှမြို့')->after('departure_date')->nullable();
            $table->string('to')->comment('သို့မြို့')->after('from')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->string('route', 100)->nullable()->after('departure_date')->comment('ခရီးစဉ်');
            $table->dropColumn('from');
            $table->dropColumn('to');
        });
    }
};
