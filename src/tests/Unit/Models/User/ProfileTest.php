<?php

namespace Tests\Unit\Models\User;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User\User;
use App\Models\User\Profile;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function ProfileCreate()
    {
        $faker = app()->make(Faker::class);
        $prevCount = Profile::count();
        $user = factory(User::class)->create();
        $profile = Profile::create(
            [
                'user_id' => $user->id,
                'displayName' => $faker->name,
                'comment' => $faker->sentence,
            ]
        );

        $afterCount = Profile::count();
        $this->assertTrue($profile->id > 0);
        $this->assertSame($afterCount, $prevCount + 1);
    }
}
