<?php

declare(strict_types=1);

/** @var Factory $factory */

use App\Models\Report;
use App\Models\Review;
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

$factory->define(
    Report::class,
    function (Faker $faker) {
        return [
            'review_id' => Review::inRandomOrder()->first()->id,
        ];
    }
);
