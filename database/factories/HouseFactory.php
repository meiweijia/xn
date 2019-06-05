<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\House;
use Faker\Generator as Faker;

$factory->define(House::class, function (Faker $faker) {

    //随机去一栋楼
    $category = \App\Models\Category::query()->inRandomOrder()->first();
    //随机取一个物业
    $property = \App\Models\Property::query()->inRandomOrder()->first();

    $image = $faker->randomElement([
        "https://lccdn.phphub.org/uploads/images/201806/01/5320/7kG1HekGK6.jpg",
        "https://lccdn.phphub.org/uploads/images/201806/01/5320/1B3n0ATKrn.jpg",
        "https://lccdn.phphub.org/uploads/images/201806/01/5320/r3BNRe4zXG.jpg",
        "https://lccdn.phphub.org/uploads/images/201806/01/5320/C0bVuKB2nt.jpg",
        "https://lccdn.phphub.org/uploads/images/201806/01/5320/82Wf2sg8gM.jpg",
        "https://lccdn.phphub.org/uploads/images/201806/01/5320/nIvBAQO5Pj.jpg",
        "https://lccdn.phphub.org/uploads/images/201806/01/5320/XrtIwzrxj7.jpg",
        "https://lccdn.phphub.org/uploads/images/201806/01/5320/uYEHCJ1oRp.jpg",
        "https://lccdn.phphub.org/uploads/images/201806/01/5320/2JMRaFwRpo.jpg",
        "https://lccdn.phphub.org/uploads/images/201806/01/5320/pa7DrV43Mw.jpg",
    ]);

    $carousel = $faker->randomElements([
        "https://lccdn.phphub.org/uploads/images/201806/01/5320/7kG1HekGK6.jpg",
        "https://lccdn.phphub.org/uploads/images/201806/01/5320/1B3n0ATKrn.jpg",
        "https://lccdn.phphub.org/uploads/images/201806/01/5320/r3BNRe4zXG.jpg",
        "https://lccdn.phphub.org/uploads/images/201806/01/5320/C0bVuKB2nt.jpg",
        "https://lccdn.phphub.org/uploads/images/201806/01/5320/82Wf2sg8gM.jpg",
        "https://lccdn.phphub.org/uploads/images/201806/01/5320/nIvBAQO5Pj.jpg",
        "https://lccdn.phphub.org/uploads/images/201806/01/5320/XrtIwzrxj7.jpg",
        "https://lccdn.phphub.org/uploads/images/201806/01/5320/uYEHCJ1oRp.jpg",
        "https://lccdn.phphub.org/uploads/images/201806/01/5320/2JMRaFwRpo.jpg",
        "https://lccdn.phphub.org/uploads/images/201806/01/5320/pa7DrV43Mw.jpg",
    ], 3);

    return [
        'number' => $faker->buildingNumber,
        'category_id' => $category->id,
        'property_id' => $property->id,
        'household' => '户型' . $faker->title,
        'rent' => $faker->numberBetween(1, 1000),
        'image' => $image,
        'carousel' => $carousel,
        'description' => $faker->sentence,
        'peoples' => $faker->numberBetween(1, 5),
        'status' => true,
    ];
});
