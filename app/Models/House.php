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
        'recommend',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
        'carousel' => 'array',
        'recommend' => 'boolean'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rentLog()
    {
        return $this->hasOne(RentLog::class);
    }

    public function rentLogs()
    {
        return $this->hasMany(RentLog::class);
    }

    public function getRentAttribute($value)
    {
        return $value / 100;
    }

    public function setRentAttribute($value)
    {
        $this->attributes['rent'] = $value * 100;
    }
}
