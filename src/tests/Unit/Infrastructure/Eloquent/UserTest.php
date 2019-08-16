<?php

namespace Tests\Unit\Infrastructure\Eloquent;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use App\Infrastructure\Eloquent\UserEloquent;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function UserCreate()
    {
        $faker = app()->make(Faker::class);
        $prevCount = UserEloquent::count();
        $user = UserEloquent::create(
            [
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'email_verified_at' => now(),
                'password' => Hash::make($faker->word),
                'remember_token' => Str::random(10),
            ]
        );

        $afterCount = UserEloquent::count();
        $this->assertTrue($user->id > 0);
        $this->assertSame($afterCount, $prevCount + 1);
    }
}
