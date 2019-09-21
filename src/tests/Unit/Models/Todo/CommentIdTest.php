<?php

namespace Tests\Unit\Models\Todo;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Todo\CommentId;

class CommentIdTest extends TestCase
{
    /** @test */
    public function コンストラクタ()
    {
        $id = new CommentId(1);

        $this->assertSame($id->getId(), 1);
    }

    /** @test */
    public function toArray()
    {
        $commentId = new CommentId(1);

        $this->assertSame($commentId->toArray(), ['id' => 1]);
    }
}
