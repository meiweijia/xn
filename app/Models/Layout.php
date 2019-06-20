<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Layout extends Model
{
    protected $casts = [
        'carousel' => 'array',
        'recommend' => 'boolean',
    ];

    protected $fillable = [
        'category_id',
        'property',
        'name',
        'rent',
        'image',
        'carousel',
        'description',
        'recommend',
        'server_detail'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            // 如果模型的 no 字段为空
            if (is_string($model->carousel)) {
                $model->carousel = explode(',', $model->carousel);
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    //public function property()
    //{
    //    return $this->belongsTo(Property::class);
    //}

    public function houses()
    {
        return $this->hasMany(House::class);
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
