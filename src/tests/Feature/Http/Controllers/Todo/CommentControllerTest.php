<?php

namespace Tests\Feature\Http\Controllers\Todo;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Repositories\Todo\TodoRepository;
use App\Repositories\Todo\CommentRepository;
use App\Models\Todo\Comment;
use App\Models\Todo\Todo;
use App\Models\Todo\TodoId;
use App\Models\User\UserId;
use Mockery;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class CommentControllerTest extends TestCase
{
    use WithoutMiddleware;

    /** @var Mockery\MockInterface */
    private $commentRepositoryMock;

    public function setUp()
    {
        parent::setUp();

        // 依存をモックする
        $this->commentRepositoryMock = Mockery::mock(CommentRepository::class);

        // 注入
        app()->instance(CommentRepository::class, $this->commentRepositoryMock);
    }

    public function tearDown()
    {
        parent::tearDown();

        // close
        Mockery::close();
    }

    /** @test */
    public function getCommentsByTodoId正常系()
    {
        $comment = new Comment(
            new UserId(1),
            new TodoId(2),
            'comment'
        );

        $this->commentRepositoryMock
            ->shouldReceive('getCommentsFromTodoId')
            ->once()
            ->andReturn(
                collect([$comment])
            );

        $response = $this->getJson(
            route(
                'getCommentsByTodoId',
                [
                    'todo_id' => 2,
                ]
            )
        );

        $response->assertStatus(200);
        $response->assertExactJson(
            [
                $comment->toArray()
            ]
        );

        $this->commentRepositoryMock
            ->shouldHaveReceived('getCommentsFromTodoId')
            ->with(
                \Hamcrest\Matchers::equalTo(
                    new TodoId(2)
                )
            );
    }

    /** @test */
    public function getCommentsByTodoId_異常系_idNotFound()
    {
        $this->commentRepositoryMock
            ->shouldReceive('getCommentsFromTodoId')
            ->once()
            ->andReturn(
                collect([])
            );

        $response = $this->getJson(
            route(
                'getCommentsByTodoId',
                [
                    'todo_id' => 1,
                ]
            )
        );

        $response->assertStatus(200);
        $response->assertExactJson(
            []
        );

        $this->commentRepositoryMock
            ->shouldHaveReceived('getCommentsFromTodoId')
            ->with(
                \Hamcrest\Matchers::equalTo(
                    new TodoId(1)
                )
            );
    }
}
