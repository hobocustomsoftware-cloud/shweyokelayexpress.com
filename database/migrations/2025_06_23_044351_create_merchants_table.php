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
        if (!Schema::hasTable('merchants')) {
            Schema::create('merchants', function (Blueprint $table) {
                $table->id();
                $table->string('name', 50)->comment('ကုန်သည် အမည်');
                $table->string('phone', 50)->comment('ကုန်သည် ဖုန်းနံပါတ်');
                $table->string('nrc', 50)->comment('ကုန်သည် မှတ်ပုံတင်အမှတ်')->nullable();
                $table->string('address', 50)->comment('ကုန်သည် လိပ်စာ')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marchants');
    }
};
