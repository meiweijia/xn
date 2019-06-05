<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Property;
use Faker\Generator as Faker;

$factory->define(Property::class, function (Faker $faker) {
    return [
        'name' => $faker->name
    ];
});
