<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Day;
use App\Shift;
use Faker\Generator as Faker;


$factory->define(Day::class, function (Faker $faker) {
    return [
        'title' => $faker->dayOfWeek,
    ];
});
