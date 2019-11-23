<?php

namespace App\Http\Controllers;

use App\Models\JobLog;
use Illuminate\Http\Request;

class JobLogController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth:api')->only('store');
    }

    public function index(Request $request)
    {
        $this->setWith('user');
        return parent::index($request);
    }

    public function store(Request $request)
    {
        $result = $request->user()->job_logs()->create($request->only([
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

    public function destroy(JobLog $jobLog)
    {
        $jobLog->delete();
        return $this->success([]);
    }
}
