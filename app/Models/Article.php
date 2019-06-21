<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'title',//标题
        'content',//内容
        'images',//图片
    ];
}
