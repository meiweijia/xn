<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends ApiController
{
    public function store(Request $request)
    {
        $result = Post::query()->create($request->only([
            'post',//岗位申请
            'leave_date',//'休假日期
            'detail',//'详细说明
        ]));
        return $this->success($result);
    }
}
