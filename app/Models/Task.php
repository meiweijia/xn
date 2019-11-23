<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $casts = [
        'images' => 'array',
        'receipt_images' => 'array'
    ];

    protected $fillable = [
        'executor_id',//指派人
        'user_id',//发起人
        'title',//任务
        'detail',//详细说明
        'images',//图片
        'receipt_detail',//完成任务说明
        'receipt_images',//完成任务图片
    ];

    public function executor(){
        return $this->belongsTo(User::class,'executor_id','id');
    }
}
