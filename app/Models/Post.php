<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'category_id',//楼栋
        'name',//姓名
        'post',//岗位申请
        'leave_date',//'休假日期
        'detail',//'详细说明
    ];
}
