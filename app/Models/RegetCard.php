<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegetCard extends Model
{
    protected $casts = [
        'images' => 'array',
    ];

    protected $fillable = [
        'house_id',
        'number',//'补卡数量
        'images',//'身份证
    ];

    public function house()
    {
        return $this->belongsTo(House::class);
    }
}
