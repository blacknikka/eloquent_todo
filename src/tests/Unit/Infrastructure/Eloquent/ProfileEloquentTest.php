<?php

namespace Tests\Unit\Infrastructure\Eloquent;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Infrastructure\Eloquent\UserEloquent;
use App\Infrastructure\Eloquent\ProfileEloquent;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

class ProfileEloquentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function ProfileCreate()
    {
        $faker = app()->make(Faker::class);
        $prevCount = ProfileEloquent::count();
        $user = factory(UserEloquent::class)->create();
        $profile = ProfileEloquent::create(
            [
                'user_id' => $user->id,
                'displayName' => $faker->name,
                'comment' => $faker->sentence,
            ]
        );

        $afterCount = ProfileEloquent::count();
        $this->assertTrue($profile->id > 0);
        $this->assertSame($afterCount, $prevCount + 1);
    }
}
