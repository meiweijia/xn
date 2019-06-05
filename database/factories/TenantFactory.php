<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Tenant;
use Faker\Generator as Faker;

$factory->define(Tenant::class, function (Faker $faker) {
    //随机取一个房间
    $house = \App\Models\House::query()->inRandomOrder()->first();

    $id_card_images = $faker->randomElements([
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
    ], 2);

    return [
        'house_id' => $house->id,
        'name' => $faker->name,
        'id_card' => $faker->phoneNumber,
        'id_card_images' => $id_card_images,
        'tel' => $faker->phoneNumber
    ];
});
