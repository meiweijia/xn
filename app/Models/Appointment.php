<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'name',
        'tel',
        'house_id',
        'date',
        'remark',
    ];

    public function house()
    {
        return $this->belongsTo(House::class);
    }
}
