<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PublicAreaClean extends Model
{
    protected $fillable = [
        'category_id',
        'name',//联系人
        'status',//卫生状况
        'remark',//其他'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
