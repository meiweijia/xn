<?php

namespace App\Http\Controllers;

use App\Models\PublicArea;
use Illuminate\Http\Request;

class PublicAreaController extends ApiController
{
    public function index(Request $request)
    {
        $this->setWith('category');
        return parent::index($request);
    }

    public function store(Request $request)
    {
        $result = PublicArea::query()->create($request->only([
            'category_id',
            'type',//'报修事宜
            'name',//报修人
            'phone',//报修联系电话
            'repair_date',//维修日期
            'duty',//事故责任
            'detail',//详细说明
            'images',//图片
        ]));
        return $this->success($result);
    }
}
