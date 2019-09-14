<?php

use Faker\Generator as Faker;
use App\Infrastructure\Eloquent\Todo\TreePathEloquent;

$factory->define(TreePathEloquent::class, function (Faker $faker) {
    return [
        'ancestor' => function () {
            return factory(
                App\Infrastructure\Eloquent\Todo\CommentEloquent::class
            )->create()->id;
        },
        'descendant' => function () {
            return factory(
                App\Infrastructure\Eloquent\Todo\CommentEloquent::class
            )->create()->id;
        },
    ];
});
