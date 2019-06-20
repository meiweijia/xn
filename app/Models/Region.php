<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public static function getName($id)
    {
        return Region::query()->find($id)->value('name');
    }
}
