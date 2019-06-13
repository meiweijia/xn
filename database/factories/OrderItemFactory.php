<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\OrderItem;
use Faker\Generator as Faker;

$factory->define(OrderItem::class, function (Faker $faker) {
    //随机取一套房
    $house = \App\Models\House::query()->where('status', true)->inRandomOrder()->first();
    return [
        'house_id' => $house->id,
        'price' => $house->rent,
    ];
});
