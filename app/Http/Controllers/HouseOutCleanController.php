<?php

namespace App\Http\Controllers;

use App\Models\HouseOutClean;
use Illuminate\Http\Request;

class HouseOutCleanController extends ApiController
{

    public function index(Request $request)
    {
        $this->setWith('house.category');
        return parent::index($request);
    }

    public function store(Request $request)
    {
        $result = HouseOutClean::query()->create($request->only([
            'house_id',
            'name',//联系人
            'status',//卫生状况
            'detail',//详细说明
        ]));
        return $this->success($result);
    }
}
