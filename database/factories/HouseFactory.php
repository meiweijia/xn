<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\House;
use Faker\Generator as Faker;

$factory->define(House::class, function (Faker $faker) {

    //随机取一个户型
    $layout = \App\Models\Layout::query()->inRandomOrder()->first();

    return [
        'number' => $faker->buildingNumber,
        'layout_id' => $layout->id,
        'peoples' => $faker->numberBetween(1, 5),
        'status' => true,
    ];
});
