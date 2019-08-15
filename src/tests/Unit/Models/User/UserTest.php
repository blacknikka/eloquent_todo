<?php

namespace Tests\Unit\Models\User;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use App\Models\User\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function UserCreate()
    {
        $faker = app()->make(Faker::class);
        $prevCount = User::count();
        $user = User::create(
            [
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'email_verified_at' => now(),
                'password' => Hash::make($faker->word),
                'remember_token' => Str::random(10),
            ]
        );

        $afterCount = User::count();
        $this->assertTrue($user->id > 0);
        $this->assertSame($afterCount, $prevCount + 1);
    }
}
