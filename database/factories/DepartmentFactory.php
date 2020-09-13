<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Deparment;
use Faker\Generator as Faker;

$factory->define(Deparment::class, function (Faker $faker) {
    $name = $faker->word;
    return [
        'name' => $name,
        'code' => strtoupper($name)
    ];
});
