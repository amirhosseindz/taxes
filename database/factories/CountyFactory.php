<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\County;
use Faker\Generator as Faker;

$factory->define(County::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'tax_rate' => $faker->numberBetween(1, 50),
        'collected_taxes' => $faker->numberBetween(100, 1000000)
    ];
});
