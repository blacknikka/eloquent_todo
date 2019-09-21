<?php

namespace Tests\Unit\Models\Todo;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Todo\Comment;
use App\Models\Todo\TodoId;
use App\Models\User\UserId;

class CommentTest extends TestCase
{
    /** @test */
    public function コンストラクタ()
    {
        $comment = new Comment(
            new UserId(1),
            new TodoId(2),
            'comment'
        );

        $this->assertSame($comment->getUserId()->getId(), 1);
        $this->assertSame($comment->getTodoId()->getId(), 2);
        $this->assertSame($comment->getComment(), 'comment');
    }

    /** @test */
    public function toArray()
    {
        $comment = new Comment(
            new UserId(1),
            new TodoId(2),
            'comment'
        );

        $this->assertSame(
            $comment->toArray(),
            [
                'user_id' => [
                    'id' => 1,
                ],
                'todo_id' => [
                    'id' => 2,
                ],
                'comment' => 'comment',
            ]
        );
    }
}
