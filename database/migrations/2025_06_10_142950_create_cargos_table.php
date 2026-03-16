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
        Schema::create('cargos', function (Blueprint $table) {
            $table->id();
            // Sender information
            $table->string('s_name_string', 100)->comment('ပို့သူအမည်')->nullable();
            $table->string('s_phone', 20)->comment('ပို့သူဖုန်း');
            $table->string('s_nrc', 50)->comment('ပို့သူမှတ်ပုံတင်အမှတ်');
            $table->text('s_address')->comment('ပို့သူလိပ်စာ');

            // Receiver information
            $table->string('r_name_string', 100)->comment('လက်ခံသူအမည်')->nullable();
            $table->string('r_phone', 20)->comment('လက်ခံသူဖုန်း');
            $table->string('r_nrc', 50)->comment('လက်ခံသူမှတ်ပုံတင်အမှတ်');
            $table->text('r_address')->comment('လက်ခံသူလိပ်စာ');

            // Cargo details
            $table->string('cargo_no', 50)->comment('ကုန်နံပါတ်');
            $table->foreignId('from_city_id')->constrained('cities')->comment('မှ မြို့နယ်');
            $table->foreignId('to_city_id')->constrained('cities')->comment('သို့ မြိုနယ်');
            $table->foreignId('from_gate_id')->constrained('gates')->comment('မှ ဂိတ်');
            $table->foreignId('to_gate_id')->constrained('gates')->comment('သို့ ဂိတ်');
            $table->unsignedTinyInteger('quantity')->default(1)->comment('ကုန်ပစ္စည်းအရေအတွက်');
            $table->foreignId('cargo_type_id')->constrained('cargo_types')->comment('ကုန်ပစ္စည်းအမျိုးအစား');
            $table->integer('media_id')->nullable();
            $table->enum('status', ['registered', 'delivered', 'taken', 'lost', 'deleted'])->default('registered')->comment('ကုန်ပစ္စည်းအခြေအနေ');

            // Financial information
            $table->decimal('service_charge', 12, 2)->comment('တန်ဆာခ')->default(0);
            $table->decimal('short_deli_fee', 12, 2)->default(0)->comment('ခေါက်တိုကြေး');
            $table->decimal('final_deli_fee', 12, 2)->default(0)->comment('အရောက်ပို့ကြေး');
            $table->decimal('border_fee', 12, 2)->default(0)->comment('ဘော်ဒါကြေး');
            $table->decimal('total_fee', 12, 2)->default(0)->comment('ကျသင့်ငွေစုစုပေါင်း');

            // Payment status
            $table->boolean('is_short_fee_paid')->default(false)->comment('ခေါက်တိုကြေးပေးပြီး');
            $table->boolean('is_final_fee_paid')->default(false)->comment('အရောက်ပို့ကြေးပေးပြီး');

            // Cash details
            $table->decimal('instant_cash', 12, 2)->default(0)->comment('လက်ငင်းငွေသား');
            $table->decimal('loan_cash', 12, 2)->default(0)->comment('စိုက်ရှင်းငွေသား');

            // Logistics
            $table->dateTime('to_pick_date')->nullable()->comment('ကုန်းရွေးရမည့်ရက်');
            $table->string('voucher_number', 50)->unique()->comment('ဘောက်ချာ နံပါတ်');

            // Additional info
            $table->text('note')->nullable();
            $table->enum('delivery_type', ['home', 'gate'])->default('home')->comment('ပို့ဆောင်မှုအမျိုးအစား');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cargos');
    }
};
