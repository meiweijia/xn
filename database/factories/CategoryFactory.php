<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    //随机取一个区域
    $region = \App\Models\Region::query()->inRandomOrder()->first();

    return [
        'name' => $faker->name,
        'region_id' => $region->id,
        'type' => $faker->numberBetween(1, 3),
    ];
});
