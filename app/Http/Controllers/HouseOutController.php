<?php

namespace App\Http\Controllers;

use App\Models\HouseOut;
use Illuminate\Http\Request;

class HouseOutController extends ApiController
{
    public function store(Request $request)
    {
        $result = HouseOut::query()->create($request->only([
            'house_id',
            'bathroom',//卫浴区 1正常 2有损 3有污渍 4严重损坏
            'parlour',//客厅区 1正常 2有损 3有污渍 4严重损坏
            'kitchen',//厨房区 1正常 2有损 3有污渍 4严重损坏
            'bedroom1',//卧室区1 1正常 2有损 3有污渍 4严重损坏
            'bedroom2',//卧室区2 1正常 2有损 3有污渍 4严重损坏
            'bedroom3',//卧室区3 1正常 2有损 3有污渍 4严重损坏
            'bedroom4',//卧室区4 1正常 2有损 3有污渍 4严重损坏
            'images',//照片
        ]));
        return $this->success($result);
    }
}
