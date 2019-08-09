<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\House;
use Faker\Generator as Faker;

$factory->define(House::class, function (Faker $faker) {
    //随机取一栋楼
    $category = \App\Models\Category::query()->inRandomOrder()->first();

    //随机取该楼中的一个户型
    $layout = \App\Models\Layout::query()->where('category_id', $category->id)->inRandomOrder()->first();

    return [
        'number' => $faker->buildingNumber,
        'category_id' => $category->id,
        'layout_id' => $layout->id ?? 1,
        'peoples' => $faker->numberBetween(1, 5),
        'status' => true,
    ];
});
