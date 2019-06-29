<?php
/**
 * Created by PhpStorm.
 * User: mei
 * Date: 6/29/19
 * Time: 11:47 AM
 */

namespace App\Services;


use App\Models\House;

class OrderService
{
    public function store(User $user, $items)
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
                $house = House::query()->find($data['sku_id']);
                // 创建一个 OrderItem 并直接与当前订单关联
                $item = $order->items()->make([
                    'amount' => $data['amount'],
                    'price' => $sku->price,
                ]);
                $item->product()->associate($sku->product_id);
                $item->save();
                $totalAmount += $sku->price;
            }

            // 更新订单总金额
            $order->update(['total_amount' => $totalAmount]);

            return $order;
        });

        // 指定时间过后如果还没有支付，就关闭订单。
        dispatch(new CloseOrder($order, config('app.order_ttl')));

        return $order;
    }
}
