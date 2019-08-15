<?php

use Faker\Generator as Faker;
use App\Models\User\Profile;

$factory->define(Profile::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(App\Models\User\User::class)->create()->id;
        },
        'displayName' => $faker->name,
        'comment' => $faker->sentence(rand(6, 10)),
    ];
});
