<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = [
        'id',
        'path',
        'type',
        'mime_type',
        'file_name',
        'file_size',
        'created_at',
        'updated_at'
    ];
}
