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
            'executor_id',//执行人
            'title',//任务
            'detail',//详细说明
            'images',//图片
            'receipt_detail',//
            'receipt_images',//
        ]));
        return $this->success($result);
    }

    public function finished(Request $request, $id)
    {
        $result = Task::query()->where('id', $id)->update([
            'receipt_detail' => $request->input('receipt_detail'),
            'receipt_images' => $request->input('receipt_images'),
        ]);
        return $this->success($result);
    }
}
