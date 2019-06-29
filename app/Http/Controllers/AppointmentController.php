<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth:api')->only('store');
    }

    public function index(Request $request)
    {
        $result = Appointment::query()
            ->with([
                'house',
                'house.layout',
            ])
            ->paginate(20);
        return $this->success($result);
    }

    public function store(Request $request)
    {
        User::query()->where('id', Auth::id())->update($request->only([
            'name',
            'tel',
        ]));
        $result = $request->user()->appointments()->create($request->only([
            'house_id',//
            'name',//姓名
            'tel',//电话
            'date',//预约时间
            'remark',//其他需求
        ]));

        return $this->success($result);
    }
}
