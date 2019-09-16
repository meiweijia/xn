<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Advise extends Model
{
    protected $fillable = [
        'name',//投诉对象
        'remark',//投诉内容
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
