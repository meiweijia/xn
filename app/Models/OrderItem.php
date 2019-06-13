<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    public $timestamps = false;

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function house()
    {
        return $this->belongsTo(House::class);
    }

    public function getPriceAttribute($value)
    {
        return $value / 100;
    }

    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = $value * 100;
    }
}
