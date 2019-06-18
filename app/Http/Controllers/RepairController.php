<?php

namespace App\Http\Controllers;

use App\Models\Repair;
use Illuminate\Http\Request;

class RepairController extends ApiController
{
    public function store(Request $request)
    {
        $result = Repair::query()->create($request->only([
            'house_id',
            'name',//签约人姓名
            'repair_date',//维修日期
            'duty',//'事故责任 1自然损坏 2人为损坏 3无法判定
            'detail',//'详细说明
            'images',//图片
        ]));
        return $this->success($result);
    }
}
