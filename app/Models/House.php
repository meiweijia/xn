<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class House extends Model
{
    protected $fillable = [
        'number',
        'rent',
        'peoples',
        'recommend',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        // 监听模型创建事件，在写入数据库之前触发
        static::creating(function ($model) {
            // 如果模型的 category_id 字段为空
            if (!$model->category_id) {
                $category_id = Layout::query()->where('id', $model->layout_id)->value('category_id');
                $model->category_id = $category_id;
            }

            if (!$model->rent) {
                $rent = Layout::query()->where('id', $model->layout_id)->value('rent');
                $model->rent = $rent;
            }
        });
    }

    public function layout()
    {
        return $this->belongsTo(Layout::class);
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

    public function tenants()
    {
        return $this->hasMany(Tenant::class);
    }

    public function getRentAttribute($value)
    {
        return $value / 100;
    }

    public function setRentAttribute($value)
    {
        $this->attributes['rent'] = $value * 100;
    }

    public static function getRent($id)
    {
        $house = House::query()->find($id);
        if (!$house->rent) {
            $layout = Layout::query()->find($house->layout_id);
            return $layout->rent;
        }
        return $house->rent;
    }
}
