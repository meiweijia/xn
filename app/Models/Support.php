<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Support extends Model
{
    protected $fillable = [
        'category_id',
        'type',//投诉事项
        'detail',//详细说明
        'name',//负责人
    ];
}
