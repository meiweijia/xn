<?php

namespace App\Http\Controllers;

use App\Models\Repair;
use Illuminate\Http\Request;

class RepairController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth:api')->only('store');
    }


    public function index(Request $request)
    {
        $this->setWith(['house.category','house.layout','user']);
        return parent::index($request);
    }

    public function store(Request $request)
    {
        $result = $request->user()->repairs()->create($request->only([
            'house_id',
            'name',//签约人姓名
            'repair_date',//维修日期
            'matters',//维修事项
            'duty',//'事故责任 1自然损坏 2人为损坏 3无法判定
            'detail',//'详细说明
            'images',//图片
        ]));
        return $this->success($result);
    }
}
