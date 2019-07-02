<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HouseOutClean extends Model
{
    protected $fillable = [
        'house_id',
        'name',//联系人
        'status',//卫生状况
        'detail',//详细说明
    ];

    public function house()
    {
        return $this->belongsTo(House::class);
    }
}
