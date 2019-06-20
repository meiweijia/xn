<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    const REGION_TYPE_1 = 1;
    const REGION_TYPE_2 = 2;
    const REGION_TYPE_3 = 3;
    public static $typeMap = [
        self::REGION_TYPE_1 => '写字楼',
        self::REGION_TYPE_2 => '奢华公寓',
        self::REGION_TYPE_3 => '旺街商铺',
    ];

    public function categories()
    {
        return $this->hasMany(Category::class);
    }
}
