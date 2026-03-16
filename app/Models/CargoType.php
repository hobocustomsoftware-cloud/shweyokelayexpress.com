<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CargoType extends Model
{
    protected $fillable = [
        'name',
        'description',
        'status'
    ];

    public function cargos()
    {
        return $this->hasMany(Cargo::class);
    }
}
