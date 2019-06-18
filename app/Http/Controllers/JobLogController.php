<?php

namespace App\Http\Controllers;

use App\Models\JobLog;
use Illuminate\Http\Request;

class JobLogController extends ApiController
{
    public function store(Request $request)
    {
        $result = JobLog::query()->create($request->only([
            'user_id',
            'type',//工作日志人 1日班 2夜班
            'patrol',//巡查发现
            'images',//图片
            'vacant',//空房数量
            'vacant_number',//空房房号
            'daily_summary',//总结
            'detail',//详细描述
        ]));
        return $this->success($result);
    }
}
