<?php

namespace Tests\Feature\Http\Controllers\Todo;

use App\Infrastructure\Eloquent\UserEloquent;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Repositories\Todo\TodoRepository;
use App\Repositories\Todo\CommentRepository;
use App\Models\Todo\Comment;
use App\Models\Todo\CommentId;
use App\Models\Todo\Todo;
use App\Models\Todo\TodoId;
use App\Models\User\UserId;
use Mockery;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Auth;

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

    /** @test */
    public function createCommentToComment_user非認証()
    {
        // user非認証
        $response = $this->postJson(
            route(
                'createCommentToComment',
                [
                    'todo_id' => 1,
                    'comment_id' => 2,
                ]
            ),
            [
                'comment' => 'comment',
            ]
        );

        $response->assertStatus(200);
        $response->assertExactJson(
            [
                'result' => false,
                'id' => null,
                'message' => "user isn't authenticated.",
            ]
        );
    }

    /** @test */
    public function createCommentToComment_createCommentがnull返却()
    {
        $this->commentRepositoryMock
            ->shouldReceive('createComment')
            ->once()
            ->andReturn(null);

        $user = factory(UserEloquent::class)->create();
        // loginしたことにする
        $this->actingAs($user);
        $this->assertTrue(Auth::check());

        $response = $this->postJson(
            route(
                'createCommentToComment',
                [
                    'todo_id' => 1,
                    'comment_id' => 2,
                ]
            ),
            [
                'comment' => 'comment',
            ]
        );

        $response->assertStatus(200);
        $response->assertExactJson(
            [
                'result' => false,
                'id' => null,
            ]
        );

        $this->commentRepositoryMock
            ->shouldHaveReceived('createComment')
            ->with(
                \Hamcrest\Matchers::equalTo(
                    new Comment(
                        new UserId($user->id),
                        new TodoId(1),
                        'comment'
                    )
                ),
                \Hamcrest\Matchers::equalTo(
                    new CommentId(2)
                )
            );
    }

    /** @test */
    public function createCommentToComment_createCommentが正常値返却()
    {
        $this->commentRepositoryMock
            ->shouldReceive('createComment')
            ->once()
            ->andReturn(new CommentId(2));

        $user = factory(UserEloquent::class)->create();
        // loginしたことにする
        $this->actingAs($user);
        $this->assertTrue(Auth::check());

        $response = $this->postJson(
            route(
                'createCommentToComment',
                [
                    'todo_id' => 1,
                    'comment_id' => 2,
                ]
            ),
            [
                'comment' => 'comment',
            ]
        );

        $response->assertStatus(200);
        $response->assertExactJson(
            [
                'result' => true,
                'id' => [
                    'id' => 2,
                ],
            ]
        );

        $this->commentRepositoryMock
            ->shouldHaveReceived('createComment')
            ->with(
                \Hamcrest\Matchers::equalTo(
                    new Comment(
                        new UserId($user->id),
                        new TodoId(1),
                        'comment'
                    )
                ),
                \Hamcrest\Matchers::equalTo(
                    new CommentId(2)
                )
            );
    }
}
