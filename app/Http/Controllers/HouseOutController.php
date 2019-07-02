<?php

namespace App\Http\Controllers;

use App\Models\HouseOut;
use Illuminate\Http\Request;

class HouseOutController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth:api')->only('store');
    }

    public function index(Request $request)
    {
        $this->setWith('house');
        return parent::index($request);
    }

    public function store(Request $request)
    {
        $house = $request->user()->house()->first();
        $data = $request->only([
            'bathroom',//卫浴区 1正常 2有损 3有污渍 4严重损坏
            'parlour',//客厅区 1正常 2有损 3有污渍 4严重损坏
            'kitchen',//厨房区 1正常 2有损 3有污渍 4严重损坏
            'bedroom',//卧室区 1正常 2有损 3有污渍 4严重损坏
            'images',//照片
        ]);
        $data['house_id'] = $house->id;
        $result = $request->user()->houseOuts()->create($data);
        return $this->success($result);
    }
}
