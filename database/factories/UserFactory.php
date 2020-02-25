<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Unit;
use App\User;
use Carbon\Carbon;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'family' => $faker->lastName,
        'national_code' =>  $faker->unique()->numberBetween(100,10000),
        'personal_code' =>  $faker->unique()->numberBetween(100,10000),
        'unit_id'=>random_int(1,6),
        'email_verified_at' => now(),
        'password' => bcrypt('123456789'), // password
        'remember_token' => Str::random(10),

    ];
});
