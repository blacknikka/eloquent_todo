<?php

namespace Tests\Unit\Models\Todo;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Todo\Todo;
use App\Models\User\UserId;

class TodoTest extends TestCase
{
    /** @test */
    public function コンストラクタ()
    {
        $todo = new Todo(
            new UserId(1),
            'comment',
            'title'
        );

        $this->assertSame($todo->getUserId()->getId(), 1);
        $this->assertSame($todo->getComment(), 'comment');
        $this->assertSame($todo->getTitle(), 'title');
    }
}
