<?php

use Faker\Generator as Faker;
use App\Infrastructure\Eloquent\ProfileEloquent;

$factory->define(ProfileEloquent::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(
                App\Infrastructure\Eloquent\UserEloquent::class
            )->create()->id;
        },
        'displayName' => $faker->name,
        'comment' => $faker->sentence(rand(6, 10)),
    ];
});
