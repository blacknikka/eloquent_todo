<?php

namespace Tests\Unit\Models\Todo;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Todo\TodoId;

class TodoIdTest extends TestCase
{
    /** @test */
    public function コンストラクタ()
    {
        $id = new TodoId(1);

        $this->assertSame($id->getId(), 1);
    }
}
