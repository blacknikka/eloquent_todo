<?php

use Faker\Generator as Faker;
use App\User\Profile;

$factory->define(Profile::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(App\User::class)->create()->id;
        },
        'displayName' => $faker->name,
        'comment' => $faker->sentences,
    ];
});
