<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Region;
use Faker\Generator as Faker;

$factory->define(Region::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'type' => $faker->numberBetween(1, 3),
    ];
});
