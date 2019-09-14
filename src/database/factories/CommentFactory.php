<?php

use Faker\Generator as Faker;

$factory->define(App\Infrastructure\Eloquent\Todo\CommentEloquent::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(
                App\Infrastructure\Eloquent\UserEloquent::class
            )->create()->id;
        },
        'todo_id' => function () {
            return factory(
                App\Infrastructure\Eloquent\Todo\TodoEloquent::class
            )->create()->id;
        },
        'comment' => $faker->sentence(rand(6, 10)),
    ];
});
