<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Services\OrderService;
use App\Services\WechatService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends ApiController
{
    public function index(Request $request)
    {
        return $this->success($request->user()->orders()->paginate(20));
    }

    public function store(Request $request, OrderService $orderService, WechatService $wechatService)
    {
        $user = $request->user();
        User::query()->where('id', $user->id)->update($request->only([
            'name',
            'tel'
        ]));

        $house_id = explode(',', $request->input('house_id'));
        //创建订单
        $order = $orderService->store($user, $house_id);

        //微信那边下单
        $notify = config('wechat.payment.default.notify_url');
        $openid = $request->user()->openid;
        $config = $wechatService->order($order->no, $order->rent * 100, '鑫南支付中心-房租支付', $openid, $notify);
        if (!$config) {//微信下单失败  删除原来订单
            $order->delete();
        }

        return $config ? $this->success($config) : $this->error([], '微信支付签名验证失败');
    }
}
