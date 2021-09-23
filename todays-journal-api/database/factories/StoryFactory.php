<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Story;
use App\User;
use Faker\Generator as Faker;

$factory->define(Story::class, function (Faker $faker) {
    return [
        'user_id' => factory(User::class),
        'title' => $faker->sentence(4),
        'url' => $faker->slug,
        'content' => $faker->sentences(3, true)
    ];
});
