<?php

namespace Tests\Unit\Repositories\Todo;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Repositories\Todo\CommentRepository;
use App\Infrastructure\Eloquent\Todo\CommentEloquent;
use App\Infrastructure\Eloquent\Todo\TreePathEloquent;
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

    /** @var Mockery\MockInterface */
    private $treePathEloquentMock;

    public function setUp()
    {
        parent::setUp();

        // 依存をモックする
        $this->commentEloquentMock = Mockery::mock(CommentEloquent::class);
        $this->treePathEloquentMock = Mockery::mock(TreePathEloquent::class);

        // 注入
        app()->instance(CommentEloquent::class, $this->commentEloquentMock);
        app()->instance(TreePathEloquent::class, $this->treePathEloquentMock);

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
    public function CommentEloquentとTreePathEloquentのMockが呼ばれていることを確認()
    {
        $commentEloquent = factory(CommentEloquent::class)->create();
        $treePathEloquent = factory(TreePathEloquent::class)->create();

        $this->commentEloquentMock
            ->shouldReceive('create')
            ->andReturn($commentEloquent);

        $this->treePathEloquentMock
            ->shouldReceive('create')
            ->andReturn($treePathEloquent);

        $this->sut->createComment(
            new Comment(
                new UserId($commentEloquent->id),
                new TodoId(2),
                'comment'
            ),
            new CommentId(10)
        );

        // mockが呼ばれていること。
        $this->commentEloquentMock
            ->shouldHaveReceived('create');

        $this->treePathEloquentMock
            ->shouldHaveReceived('create');
    }

    /** @test */
    public function createComment_正常系()
    {
        $commentEloquent = factory(CommentEloquent::class)->create();
        $treePathEloquent = factory(TreePathEloquent::class)->create();

        $this->commentEloquentMock
            ->shouldReceive('create')
            ->andReturn($commentEloquent);

        $this->treePathEloquentMock
            ->shouldReceive('create')
            ->andReturn($treePathEloquent);

        $createdCommentId = $this->sut->createComment(
            new Comment(
                new UserId($commentEloquent->id),
                new TodoId(2),
                'comment'
            ),
            new CommentId(10)
        );

        // 作成されたIDがfactoryが作ったものと同じ。
        $this->assertSame($createdCommentId->getId(), $commentEloquent->id);
    }
}
