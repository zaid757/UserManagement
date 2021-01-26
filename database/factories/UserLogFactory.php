<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\UserLog;
use Faker\Generator as Faker;

$factory->define(UserLog::class, function (Faker $faker) {
    return [
        'user_id' => 1,
        'slug' => 'random_action',
        'message' => $faker->sentence(12),

    ];
});
