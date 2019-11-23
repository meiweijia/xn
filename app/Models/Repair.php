<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Repair extends Model
{
    protected $casts = [
        'images' => 'array',
    ];

    protected $fillable = [
        'house_id',
        'name',//签约人姓名
        'repair_date',//维修日期
        'matters',//维修事项
        'duty',//'事故责任 1自然损坏 2人为损坏 3无法判定
        'detail',//'详细说明
        'images',//图片
    ];

    protected static function boot()
    {
        parent::boot();
        // 监听模型创建事件，在写入数据库之前触发
        static::creating(function ($model) {
            $house = House::query()->where('user_id', Auth::id())->first();
            $model->house_id = $house->id;
        });
    }

    public function house()
    {
        return $this->belongsTo(House::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
