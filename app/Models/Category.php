<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    const CATEGORY_TYPE_1 = 1;
    const CATEGORY_TYPE_2 = 2;
    const CATEGORY_TYPE_3 = 3;
    public static $typeMap = [
        self::CATEGORY_TYPE_1 => '写字楼',
        self::CATEGORY_TYPE_2 => '奢华公寓',
        self::CATEGORY_TYPE_3 => '旺街商铺',
    ];

    public static function getName($id)
    {
        return Category::query()->find($id)->value('name');
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function houses()
    {
        return $this->hasMany(House::class);
    }

    public function users()
    {
        return $this->belongsToMany(Category::class);
    }
}
