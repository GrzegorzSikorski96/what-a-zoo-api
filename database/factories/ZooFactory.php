<?php

declare(strict_types=1);

/** @var Factory $factory */

use App\Models\Zoo;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

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

$factory->define(Zoo::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'latitude' => random_int(-90, 90),
        'longitude' => random_int(-180, 180),
    ];
});
