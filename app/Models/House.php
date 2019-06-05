<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class House extends Model
{
    protected $fillable = [
        'number',
        'household',
        'rent',
        'image',
        'carousel',
        'description',
        'peoples',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
        'carousel' => 'array',
    ];
}
