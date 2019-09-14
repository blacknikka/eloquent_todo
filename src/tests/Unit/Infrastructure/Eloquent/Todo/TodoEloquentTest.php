<?php

namespace Tests\Unit\Infrastructure\Eloquent\Todo;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Infrastructure\Eloquent\UserEloquent;
use App\Infrastructure\Eloquent\Todo\TodoEloquent;
use Faker\Generator as Faker;

class TodoEloquentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function factoryテスト()
    {
        $count = TodoEloquent::count();
        $todo = factory(TodoEloquent::class)->create();
        $this->assertSame($count + 1, TodoEloquent::count());
        $this->assertTrue($todo->id > 0);
    }

    /** @test */
    public function TodoCreate()
    {
        $faker = app()->make(Faker::class);
        $prevCount = TodoEloquent::count();
        $user = factory(UserEloquent::class)->create();
        $todo = TodoEloquent::create(
            [
                'user_id' => $user->id,
                'comment' => $faker->sentence,
                'title' => $faker->sentence,
            ]
        );

        $afterCount = TodoEloquent::count();
        $this->assertTrue($todo->id > 0);
        $this->assertSame($afterCount, $prevCount + 1);
    }

    /** @test */
    public function user取得()
    {
        $faker = app()->make(Faker::class);
        $user = factory(UserEloquent::class)->create();

        $created = TodoEloquent::create(
            [
                'user_id' => $user->id,
                'comment' => $faker->sentence,
                'title' => $faker->sentence,
            ]
        );

        $belonged = $created->user;
        $this->assertNotNull($belonged);
        $this->assertTrue($belonged->id > 0);
        $this->assertSame($belonged->id, $user->id);
    }
}
