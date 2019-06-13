<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function houses()
    {
        return $this->hasMany(House::class);
    }
}
