<?php

namespace Tests\Unit\Models\User;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User\UserId;

class UserIdTest extends TestCase
{
    /** @test */
    public function コンストラクタ()
    {
        $userId = new UserId(1);

        $this->assertSame($userId->getId(), 1);
    }
}
