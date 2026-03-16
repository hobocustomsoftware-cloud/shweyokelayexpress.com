<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\DayOffDate;

class Car extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;
    protected $fillable = [
        'number',
        'departure_date',
        'departure_time',
        'from',
        'to',
        'driver_name',
        'driver_phone_number',
        'assistant_driver_name',
        'assistant_driver_phone',
        'spare_name',
        'spare_phone',
        'crew_name',
        'crew_phone'
    ];

    protected $casts = [
        'departure_date' => 'date:Y-m-d',
        'number' => 'string',
    ];

    public function dayOff()
    {
        return $this->hasMany(DayOffDate::class, 'car_id', 'id');
    }
}
