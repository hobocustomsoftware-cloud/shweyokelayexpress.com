<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gate extends Model
{
    protected $fillable = [
        'name_en',
        'name_my',
        'city_id',
        'description',
        'is_main',
        'is_transit'
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function getNameAttribute()
    {
        return app()->getLocale() === 'my' ? $this->name_my : $this->name_en;
    }
}
