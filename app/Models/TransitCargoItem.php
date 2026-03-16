<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransitCargoItem extends Model
{
    // ပုံထဲကအတိုင်း table နာမည်ကို cargo_items လို့ သတ်မှတ်ပေးရပါမယ်
    protected $table = 'cargo_items';

    protected $fillable = [
        'cargo_id',
        'quantity',
        'cargo_type_id',
        'detail',
        'notice'
    ];

    // Main Cargo နဲ့ ပြန်ချိတ်တာပါ
    public function transitCargo()
    {
        return $this->belongsTo(TransitCargo::class, 'cargo_id');
    }

    // ပစ္စည်းအမျိုးအစားနဲ့ ချိတ်တာပါ
    public function cargoType()
    {
        return $this->belongsTo(CargoType::class, 'cargo_type_id');
    }
}