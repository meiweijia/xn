<?php

namespace App\Http\Controllers;

use App\Models\Advise;
use Illuminate\Http\Request;

class AdviseController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth:api')->only('store');
    }

    public function index()
    {
        return Advise::query()->paginate(20);
    }

    public function store(Request $request)
    {
        $result = $request->user()->advises()->create($request->only([
            'name',//投诉对象
            'remark',//投诉内容
        ]));
        return $this->success($result);
    }
}
