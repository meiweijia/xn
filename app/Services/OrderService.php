<?php

namespace App\Services;

use App\Models\House;
use App\Models\Order;
use App\Models\User;

class OrderService
{
    public function store(User $user, array $items)
    {
        // 开启一个数据库事务
        $order = \DB::transaction(function () use ($user, $items) {
            // 创建一个订单
            $order = new Order([
                'total_amount' => 0,
            ]);
            // 订单关联到当前用户
            $order->user()->associate($user);
            // 写入数据库
            $order->save();

            $totalAmount = 0;
            // 遍历用户提交的 SKU
            foreach ($items as $data) {
                $house = House::query()->find($data['house_id']);
                // 创建一个 OrderItem 并直接与当前订单关联
                $item = $order->items()->make([
                    'price' => $house->rent,
                ]);
                $item->house()->associate($house);
                $item->save();
                $totalAmount += $house->price;
            }

            // 更新订单总金额
            $order->update(['total_amount' => $totalAmount]);

            return $order;
        });

        // 指定时间过后如果还没有支付，就关闭订单。
        //dispatch(new CloseOrder($order, config('app.order_ttl')));

        return $order;
    }
}
