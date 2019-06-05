<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    protected $fillable = [
        'name',
        'id_card',
        'id_card_images',
        'tel'
    ];

    protected $casts = [
        'id_card_images' => 'array',
    ];
}
