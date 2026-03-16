<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CargoMedia extends Model
{
    protected $table = 'cargo_media';
    protected $fillable = [
        'cargo_id',
        'media_id',
    ];

    public $timestamps = true;
    
    protected $casts = [
        'cargo_id' => 'integer',
        'media_id' => 'integer',
    ];

    public function cargo()
    {
        return $this->belongsTo(Cargo::class, 'cargo_id');
    }

    public function media()
    {
        return $this->belongsTo(Media::class, 'media_id');
    }
}
