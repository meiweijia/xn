<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    protected $fillable = [
        'user_id',
        'numbers',//访客数量
        'name',//姓名
        'phone',//电话
        'intention',//意向程度 1高 2中 3低
        'remark',//其他原因
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
