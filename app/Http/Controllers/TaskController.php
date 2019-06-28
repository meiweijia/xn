<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth:api')->only('store');
    }

    public function store(Request $request)
    {
        $result = $request->user()->tasks()->create($request->only([
            'title',//任务
            'detail',//详细说明
            'images',//图片
        ]));
        return $this->success($result);
    }
}
