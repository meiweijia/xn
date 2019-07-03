<?php

namespace App\Http\Controllers;

use App\Models\PublicAreaClean;
use Illuminate\Http\Request;

class PublicAreaCleanController extends ApiController
{
    public function index(Request $request)
    {
        $this->setWith('house.layout.category');
        return parent::index($request);
    }

    public function store(Request $request)
    {
        $result = PublicAreaClean::query()->create($request->only([
            'category_id',
            'name',//联系人
            'status',//卫生状况
            'remark',//其他'
        ]));
        return $this->success($result);
    }
}
