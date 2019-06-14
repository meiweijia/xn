<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Layout extends Model
{
    protected $casts = [
        'carousel' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    //public function property()
    //{
    //    return $this->belongsTo(Property::class);
    //}

    public function getRentAttribute($value)
    {
        return $value / 100;
    }

    public function setRentAttribute($value)
    {
        $this->attributes['rent'] = $value * 100;
    }
}
