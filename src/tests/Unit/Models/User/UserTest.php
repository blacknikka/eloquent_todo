<?php

namespace Tests\Unit\Models\User;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User\User;

class UserTest extends TestCase
{
    /** @test */
    public function コンストラクタ()
    {
        $user = new User(
            'namae',
            'email',
            'password'
        );

        $this->assertSame($user->getName(), 'namae');
        $this->assertSame($user->getEmail(), 'email');
        $this->assertSame($user->getPassword(), 'password');
    }
}
