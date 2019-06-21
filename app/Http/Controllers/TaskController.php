<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends ApiController
{
    public function index()
    {
        return Task::query()->paginate(20);
    }

    public function store(Request $request)
    {
        $result = Task::query()->create($request->only([
            'user_id',//指派人
            'title',//任务
            'detail',//详细说明
            'images',//图片
        ]));
        return $this->success($result);
    }
}
