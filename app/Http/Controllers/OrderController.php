<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth:api')->only('store');
    }

    public function store(Request $request, OrderService $service)
    {
        $user = $request->user();
        User::query()->where('id', $user->id)->update($request->only([
            'name',
            'tel'
        ]));

        $house_id = $request->input('house_id');
        $result = $service->store($user, $house_id);
        return $this->success($result);
    }
}
