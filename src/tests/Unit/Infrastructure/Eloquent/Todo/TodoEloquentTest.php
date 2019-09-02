<?php

namespace Tests\Unit\Infrastructure\Eloquent\Todo;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Infrastructure\Eloquent\UserEloquent;
use App\Infrastructure\Eloquent\Todo\TodoEloquent;
use Faker\Generator as Faker;

class TodoEloquentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function ProfileCreate()
    {
        $faker = app()->make(Faker::class);
        $prevCount = TodoEloquent::count();
        $user = factory(UserEloquent::class)->create();
        $profile = TodoEloquent::create(
            [
                'user_id' => $user->id,
                'comment' => $faker->sentence,
                'title' => $faker->sentence,
            ]
        );

        $afterCount = TodoEloquent::count();
        $this->assertTrue($profile->id > 0);
        $this->assertSame($afterCount, $prevCount + 1);
    }
}
