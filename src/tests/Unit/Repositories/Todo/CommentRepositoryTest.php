<?php

namespace Tests\Unit\Repositories\Todo;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Repositories\Todo\CommentRepository;
use App\Infrastructure\Eloquent\UserEloquent;
use App\Infrastructure\Eloquent\Todo\CommentEloquent;
use App\Infrastructure\Eloquent\Todo\TreePathEloquent;
use Mockery;
use App\Models\Todo\Comment;
use App\Models\Todo\CommentId;
use App\Models\Todo\Todo;
use App\Models\Todo\TodoId;
use App\Models\User\UserId;

use App\Exceptions\Handler;
use Exception;

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
                new UserId(1),
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
                new UserId(1),
                new TodoId(2),
                'comment'
            ),
            new CommentId(10)
        );

        // 作成されたIDがfactoryが作ったものと同じ。
        $this->assertSame($createdCommentId->getId(), $commentEloquent->id);
    }

    /** @test */
    public function create_rollback_CommentEloquentエラー()
    {
        $prevCommentCount = CommentEloquent::count();
        $prevTreePathCount = TreePathEloquent::count();

        $this->commentEloquentMock
            ->shouldReceive('create')
            ->andThrow(new Exception());

        $this->treePathEloquentMock
            ->shouldReceive('create')
            ->andReturn(null);

        try {
            $createdCommentId = $this->sut->createComment(
                new Comment(
                    new UserId(1),
                    new TodoId(2),
                    'comment'
                ),
                new CommentId(10)
            );

            $this->fail();
        } catch (Exception $e) {
            $this->assertSame($prevCommentCount, CommentEloquent::count());
            $this->assertSame($prevTreePathCount, TreePathEloquent::count());
        }
    }

    /** @test */
    public function create_rollback_TreePathEloquentエラー()
    {
        $commentEloquent = factory(CommentEloquent::class)->make();

        $this->commentEloquentMock
            ->shouldReceive('create')
            ->andReturn($commentEloquent);

        $this->treePathEloquentMock
            ->shouldReceive('create')
            ->andThrow(new Exception());

        try {
            $createdCommentId = $this->sut->createComment(
                new Comment(
                    new UserId(1),
                    new TodoId(2),
                    'comment'
                ),
                new CommentId(10)
            );

            $this->fail();
        } catch (Exception $e) {
            // $this->assertSame($prevCommentCount, CommentEloquent::count());
            // $this->assertSame($prevTreePathCount, TreePathEloquent::count());
            // $this->assertNull($createdCommentId);
        }
    }
}
