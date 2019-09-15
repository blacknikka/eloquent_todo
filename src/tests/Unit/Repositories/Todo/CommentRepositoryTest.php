<?php

namespace Tests\Unit\Repositories\Todo;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Repositories\Todo\CommentRepository;
use App\Infrastructure\Eloquent\Todo\CommentEloquent;
use Mockery;
use App\Models\Todo\Comment;
use App\Models\Todo\CommentId;
use App\Models\Todo\Todo;
use App\Models\Todo\TodoId;
use App\Models\User\UserId;

class CommentRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /** @var CommentRepository */
    private $sut;

    /** @var Mockery\MockInterface */
    private $commentEloquentMock;

    public function setUp()
    {
        parent::setUp();

        // 依存をモックする
        $this->commentEloquentMock = Mockery::mock(CommentEloquent::class);

        // 注入
        app()->instance(CommentEloquent::class, $this->commentEloquentMock);

        // テスト対象のインスタンスを取得
        $this->sut = app()->make(CommentRepository::class);
    }

    public function tearDown()
    {
        parent::tearDown();

        // close
        Mockery::close();
    }

    /** @test */
    public function CommentEloquentのMockが呼ばれていることを確認()
    {
        $this->commentEloquentMock
            ->shouldReceive('create')
            ->andReturn(new CommentId(10));

        $createdCommentId = $this->sut->createComment(
            new Comment(
                new UserId(1),
                new TodoId(1),
                'comment'
            ),
            new CommentId(1)
        );

        $this->assertSame($createdCommentId->getId(), 10);

        $this->commentEloquentMock
            ->shouldHaveReceived('create');
    }
}
