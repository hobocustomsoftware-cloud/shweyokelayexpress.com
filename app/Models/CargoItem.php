<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CargoItem extends Model

{
    
    protected $table = 'cargo_items';
    
    protected $fillable = ['cargo_id', 'quantity', 'cargo_type_id', 'detail', 'notice'];

    // public function cargo()
    // {
    //     return $this->belongsTo(Cargo::class);
    // }
    // CargoItem.php ထဲမှာ ဒါလေး ထည့်ထားပါ
    public function cargoType() {
        return $this->belongsTo(CargoType::class, 'cargo_type_id');
    }
    public function cargo()
    {
        // cargo_items table ထဲက cargo_id နဲ့ cargos table ရဲ့ id ကို ချိတ်ဆက်တာပါ
        return $this->belongsTo(\App\Models\Cargo::class, 'cargo_id');
    }
}