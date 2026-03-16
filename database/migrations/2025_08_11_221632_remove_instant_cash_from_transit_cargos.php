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
            if(Schema::hasColumn('transit_cargos', 'instant_cash')){
                $table->dropColumn('instant_cash');
            }
            if(Schema::hasColumn('transit_cargos', 'loan_cash')){
                $table->dropColumn('loan_cash');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transit_cargos', function (Blueprint $table) {
            if(Schema::hasColumn('transit_cargos', 'instant_cash')){
                $table->integer('instant_cash')->nullable();
            }
            if(Schema::hasColumn('transit_cargos', 'loan_cash')){
                $table->integer('loan_cash')->nullable();
            }
        });
    }
};
