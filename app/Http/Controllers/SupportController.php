<?php

namespace App\Http\Controllers;

use App\Models\Support;
use Illuminate\Http\Request;

class SupportController extends ApiController
{
    public function store(Request $request)
    {
        $result = Support::query()->create($request->only([
            'category_id',
            'type',//投诉事项
            'detail',//详细说明
            'name',//负责人
        ]));
        return $this->success($result);
    }
}
