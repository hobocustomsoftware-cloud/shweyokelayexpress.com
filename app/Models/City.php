<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = [
        'name_en',
        'name_my',
        'description',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    public function getNameAttribute()
    {
        return $this->attributes['name_en'];
    }

    public function gates()
    {
        return $this->hasMany(Gate::class);
    }

    public function cargos()
    {
        return $this->hasMany(Cargo::class);
    }
}
