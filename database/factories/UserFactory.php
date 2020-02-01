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
        'national_code' =>  Str::random(10),
        'personal_code' =>  Str::random(5),
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$Q5IoW9MDi2jKslAtyCaV/Ot3qbLRBtjSWsacuKN76fLOQo0az0QOO', // password
        'remember_token' => Str::random(10),
        'date_of_employment' => date("Y-m-d", strtotime("2019-09-25")),
    ];
});
