<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\RentLog;
use Faker\Generator as Faker;

$factory->define(RentLog::class, function (Faker $faker) {
    //随机取一个区域
    $region = \App\Models\Region::query()->inRandomOrder()->first();
    //随机取一栋楼
    $category = \App\Models\Category::query()->where('region_id', $region->id)->inRandomOrder()->first();
    //随机取一个物业
    //$property = \App\Models\Property::query()->inRandomOrder()->first();
    //随机取一个房间
    $house = \App\Models\House::query()->inRandomOrder()->first();

    return [
        'property' => $faker->name,
        'region_id' => $region->id,
        'category_id' => $category->id,
        'house_id' => $house->id,
        'house_number' => $house->number,
        'house_rent' => $house->rent,
        'last_electric_number' => $faker->numberBetween(0, 10),
        'electric_number' => $faker->numberBetween(10, 20),
        'last_cold_water_number' => $faker->numberBetween(0, 10),
        'cold_water_number' => $faker->numberBetween(10, 20),
        'last_hot_water_number' => $faker->numberBetween(0, 10),
        'hot_water_number' => $faker->numberBetween(10, 20),
        'other_cost' => $faker->numberBetween(20, 50),
        'status' => $faker->numberBetween(0, 1)
    ];
});
