<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CarCargo extends Model
{
    use SoftDeletes;
    protected $fillable = ['car_id', 'cargo_id', 'user_id', 'status', 'assigned_at', 'departure_date', 'arrived_at'];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function cargo()
    {
        return $this->belongsTo(Cargo::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cargo_type()
    {
        return $this->belongsTo(CargoType::class);
    }

    
}
