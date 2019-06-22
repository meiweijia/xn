<?php

namespace App\Http\Controllers;

use App\Models\Borrow;
use Illuminate\Http\Request;

class BorrowController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth:api')->only('store');
    }

    public function store(Request $request)
    {
        $result = $request->user()->borrows()->create($request->only([
            'goods',//物品
            'purpose',//'用途'
            'date',//归还日期'
            'images',//物品图片
        ]));
        return $this->success($result);
    }
}
