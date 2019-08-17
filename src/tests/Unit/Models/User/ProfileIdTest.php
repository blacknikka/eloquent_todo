<?php

namespace Tests\Unit\Models\User;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User\ProfileId;

class ProfileIdTest extends TestCase
{
    /** @test */
    public function コンストラクタ()
    {
        $profileId = new ProfileId(1);

        $this->assertSame($profileId->getId(), 1);
    }
}
