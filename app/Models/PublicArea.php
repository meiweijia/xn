<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PublicArea extends Model
{
    protected $casts = [
        'images' => 'array',
    ];

    protected $fillable = [
        'category_id',
        'type',//'报修事宜
        'name',//报修人
        'phone',//报修联系电话
        'repair_date',//维修日期
        'duty',//事故责任
        'detail',//详细说明
        'images',//图片
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
