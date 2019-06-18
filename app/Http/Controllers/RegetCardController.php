<?php

namespace App\Http\Controllers;

use App\Models\RegetCard;
use Illuminate\Http\Request;

class RegetCardController extends ApiController
{
    public function store(Request $request)
    {
        $result = RegetCard::query()->create($request->only([
            'house_id',
            'number',//'补卡数量
            'images',//'身份证
        ]));
        return $result;
    }
}
