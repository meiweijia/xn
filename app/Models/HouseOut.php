<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HouseOut extends Model
{
    protected $casts = [
        'images' => 'array',
        'bedroom' => 'array',
    ];

    protected $fillable = [
        'house_id',
        'bathroom',//卫浴区 1正常 2有损 3有污渍 4严重损坏
        'parlour',//客厅区 1正常 2有损 3有污渍 4严重损坏
        'kitchen',//厨房区 1正常 2有损 3有污渍 4严重损坏
        'bedroom',//卧室区1 1正常 2有损 3有污渍 4严重损坏
        'images',//照片
    ];
}
