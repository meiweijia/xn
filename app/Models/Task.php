<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $casts = [
        'images' => 'array',
    ];

    protected $fillable = [
        'executor_id',//指派人
        'user_id',//发起人
        'title',//任务
        'detail',//详细说明
        'images',//图片
    ];
}
