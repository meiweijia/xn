<?php

namespace App\Http\Controllers;

use App\Models\Advise;
use Illuminate\Http\Request;

class AdviseController extends ApiController
{
    public function store(Request $request)
    {
        $result = Advise::query()->create($request->only([
            'name',//投诉对象
            'remark',//投诉内容
        ]));
        return $this->success($result);
    }
}
