<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransitCargo extends Model
{
    protected $fillable = [
        // Sender information
        's_name_string',
        's_merchant_id',
        's_phone',
        's_nrc',
        's_address',

        // Receiver information
        'r_name_string',
        'r_merchant_id',
        'r_phone',
        'r_nrc',
        'r_address',

        // Cargo details
        'cargo_no',
        'from_city',
        'to_city',
        'from_gate',
        'to_gate',
        'quantity',
        'cargo_type_id',
        'media_id',
        'qrcode_image',
        'status',
        'cargo_detail_name',
        'notice_message',

        // Financial information
        'service_charge',
        'is_debt',
        
        // Logistics
        'to_pick_date',
        'voucher_number',

        // Car information
        'car_id',
    ];

    public function cargoType()
    {
        return $this->belongsTo(CargoType::class);
    }

    public function media()
    {
        return $this->belongsTo(Media::class);
    }

    public function fromCity()
    {
        return $this->belongsTo(City::class, 'from_city');
    }

    public function toCity()
    {
        return $this->belongsTo(City::class, 'to_city');
    }

    public function fromGate()
    {
        return $this->belongsTo(Gate::class, 'from_gate');
    }

    public function toGate()
    {
        return $this->belongsTo(Gate::class, 'to_gate');
    }

    public function car()
    {
        return $this->belongsTo(Car::class, 'car_id');
    }

    public function sender_merchant()
    {
        return $this->belongsTo(Merchant::class, 's_merchant_id');
    }

    public function receiver_merchant()
    {
        return $this->belongsTo(Merchant::class, 'r_merchant_id');
    }
    public function items()
    {
        // ဒါလေးထည့်မှ cargo_items table ထဲက ပစ္စည်းတွေကို ဆွဲထုတ်လို့ရမှာပါ
        return $this->hasMany(TransitCargoItem::class, 'cargo_id');
    }
}
