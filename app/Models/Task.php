<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'user_id',//指派人
        'title',//任务
        'detail',//详细说明
        'images',//图片
    ];
}
