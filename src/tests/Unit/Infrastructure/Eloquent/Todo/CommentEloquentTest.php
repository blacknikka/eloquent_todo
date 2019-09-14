<?php

namespace Tests\Unit\Infrastructure\Eloquent\Todo;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Infrastructure\Eloquent\UserEloquent;
use App\Infrastructure\Eloquent\Todo\CommentEloquent;
use App\Infrastructure\Eloquent\Todo\TodoEloquent;
use Faker\Generator as Faker;

class CommentEloquentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function factoryテスト()
    {
        $count = CommentEloquent::count();
        $comment = factory(CommentEloquent::class)->create();
        $this->assertSame($count + 1, CommentEloquent::count());
        $this->assertTrue($comment->id > 0);
    }

    /** @test */
    public function CommentCreate()
    {
        $faker = app()->make(Faker::class);
        $prevCount = CommentEloquent::count();

        // 外部キー用のデータを作成
        $user = factory(UserEloquent::class)->create();
        $todo = factory(TodoEloquent::class)->create();

        $comment = CommentEloquent::create(
            [
                'user_id' => $user->id,
                'todo_id' => $todo->id,
                'comment' => $faker->sentence,
            ]
        );

        $afterCount = CommentEloquent::count();
        $this->assertTrue($comment->id > 0);
        $this->assertSame($afterCount, $prevCount + 1);
    }
}
