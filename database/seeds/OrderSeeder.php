<?php

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $orders = factory(Order::class, 50)->create();

        foreach ($orders as $order) {
            // 每笔订单随机 1 - 3 个商品
            $items = factory(OrderItem::class, 1)->create([
                'order_id' => $order->id,
            ]);

            // 计算总价
            $total = $items->sum(function (OrderItem $item) {
                return $item->price;
            });

            // 更新订单总价
            $order->update([
                'total_amount' => $total,
            ]);
        }
    }
}
