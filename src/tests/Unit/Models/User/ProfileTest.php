<?php

namespace Tests\Unit\Models\User;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User\Profile;
use App\Models\User\UserId;

class ProfileTest extends TestCase
{
    /** @test */
    public function コンストラクタ()
    {
        $profile = new Profile(
            new UserId(1),
            'displayName',
            'comment'
        );

        $this->assertSame($profile->getUserId()->getId(), 1);
        $this->assertSame($profile->getDisplayName(), 'displayName');
        $this->assertSame($profile->getComment(), 'comment');
    }
}
