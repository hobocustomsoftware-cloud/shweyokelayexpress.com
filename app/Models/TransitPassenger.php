<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransitPassenger extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'address',
        'nrc',
        'car_id',
        'seat_number',
        'price',
        'transit_cargo_id',
        'user_id',
        'is_paid',
        'status',
        'voucher_number',
    ];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transitCargo()
    {
        return $this->belongsTo(TransitCargo::class);
    }
}
