<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Monolog\Processor\PsrLogMessageProcessor;

class Cargo extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;
    use \Illuminate\Database\Eloquent\SoftDeletes;
    protected $fillable = [
        'created_by_user_id',
        // Sender information
        's_merchant_id',
        's_name_string',
        's_phone',
        's_nrc',
        's_address',

        // Receiver information
        'r_merchant_id',
        'r_name_string',
        'r_phone',
        'r_nrc',
        'r_address',

        // Cargo details
        'cargo_no',
        'from_city_id',
        'to_city_id',
        'from_gate_id',
        'to_gate_id',
        'quantity',
        'cargo_type_id',
        'media_id',
        'status',
        'qrcode_image',
        'cargo_detail_name',
        'notice_message',

        // Financial information
        'service_charge',
        'short_deli_fee',
        'final_deli_fee',
        'border_fee',
        'transit_fee',
        'total_fee',
        'total_receive_fee',

        // Payment status
        'is_debt',

        // Logistics
        'to_pick_date',
        'voucher_number',
    ];

    protected $casts = [
        'is_debt' => 'boolean',
    ];

    public function createdByUser()
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

    public function fromCity()
    {
        return $this->belongsTo(City::class, 'from_city_id');
    }

    public function toCity()
    {
        return $this->belongsTo(City::class, 'to_city_id');   
    }

    public function fromGate()
    {
        return $this->belongsTo(Gate::class, 'from_gate_id');
    }

    public function toGate()
    {
        return $this->belongsTo(Gate::class, 'to_gate_id');
    }

    public function cargoType()
    {
        return $this->belongsTo(CargoType::class, 'cargo_type_id');
    }

    public function sender_merchant()
    {
        return $this->belongsTo(Merchant::class, 's_merchant_id');
    }

    public function receiver_merchant()
    {
        return $this->belongsTo(Merchant::class, 'r_merchant_id');
    }

    public function media()
    {
        return $this->belongsTo(Media::class, 'media_id');
    }

    public function carCargo()
    {
        return $this->hasMany(CarCargo::class);
    }
    public function items()
    {
        return $this->hasMany(CargoItem::class, 'cargo_id');
    }
    //new
}
