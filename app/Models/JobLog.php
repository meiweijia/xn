<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobLog extends Model
{
    protected $casts = [
        'images' => 'array',
    ];

    protected $fillable = [
        'type',//工作日志人 1日班 2夜班
        'patrol',//巡查发现
        'images',//图片
        'vacant',//空房数量
        'vacant_number',//空房房号
        'daily_summary',//总结
        'detail',//详细描述
    ];
}
