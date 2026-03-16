<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DayOffDate extends Model
{
    protected $table = 'cars_day_offs';
    protected $fillable = [
        'car_id',
        'day_off_date',
        'reason',
    ];

    protected $casts = [
        'day_off_date' => 'array',
    ];
}
