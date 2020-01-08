<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
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
// adapted for twitter authenticated user 
$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'provider' => 'twitter',
        'provider_id' => $faker->randomNumber(),
        'provider_token' => $faker->regexify('[A-Za-z0-9]{20}'),
        'provider_secret' => $faker->regexify('[A-Za-z0-9]{32}'),
        'remember_token' => Str::random(10),
    ];
});
