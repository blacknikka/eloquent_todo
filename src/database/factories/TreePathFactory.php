<?php

use Faker\Generator as Faker;
use App\Infrastructure\Eloquent\Todo\TreePathEloquent;

$factory->define(TreePathEloquent::class, function (Faker $faker) {
    return [
        'ancestor_id' => function () {
            return factory(
                App\Infrastructure\Eloquent\Todo\CommentEloquent::class
            )->create()->id;
        },
        'descendant_id' => function () {
            return factory(
                App\Infrastructure\Eloquent\Todo\CommentEloquent::class
            )->create()->id;
        },
    ];
});
