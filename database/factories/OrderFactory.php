<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Order;
use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker) {
    $user = \App\Models\User::query()->inRandomOrder()->first();
    return [
        'user_id' => $user->id,
        'total_amount' => 0,
        'paid_at' => $faker->dateTimeBetween('-30 days'), // 30天前到现在任意时间点
        'payment_method' => $faker->randomElement(['wechat', 'alipay']),
        'payment_no' => $faker->uuid,
        'status' => $faker->randomElement([
            Order::PAY_STATUS_PENDING,
            Order::PAY_STATUS_PROCESSING,
            Order::PAY_STATUS_SUCCESS,
            Order::PAY_STATUS_FAILED,
        ]),
    ];
});
