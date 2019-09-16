<?php

namespace Tests\Feature\Http\Controllers\Todo;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Repositories\Todo\TodoRepository;
use App\Models\Todo\Todo;
use App\Models\Todo\TodoId;
use App\Models\User\UserId;
use Mockery;

class TodoControllerTest extends TestCase
{
    /** @var Mockery\MockInterface */
    private $todoRepositoryMock;

    public function setUp()
    {
        parent::setUp();

        // 依存をモックする
        $this->todoRepositoryMock = Mockery::mock(TodoRepository::class);

        // 注入
        app()->instance(TodoRepository::class, $this->todoRepositoryMock);
    }

    public function tearDown()
    {
        parent::tearDown();

        // close
        Mockery::close();
    }

    /** @test */
    public function get正常系()
    {
        $todo = new Todo(
            new UserId(1),
            'comment',
            'title'
        );

        $this->todoRepositoryMock
            ->shouldReceive('getTodosByUserId')
            ->once()
            ->andReturn(
                collect([$todo])
            );

        $response = $this->getJson(
            route(
                'getTodo',
                [
                    'id' => 1,
                ]
            )
        );

        $response->assertStatus(200);
        $response->assertExactJson(
            [
                $todo->toArray()
            ]
        );

        $this->todoRepositoryMock
            ->shouldHaveReceived('getTodosByUserId')
            ->with(
                \Hamcrest\Matchers::equalTo(
                    new UserId(1)
                )
            );
    }

    /** @test */
    public function create_正常系()
    {
        $todoId = new TodoId(1);

        $this->todoRepositoryMock
            ->shouldReceive('createTodo')
            ->once()
            ->andReturn(
                $todoId
            );

        $response = $this->postJson(
            route(
                'createTodo',
                [
                    'id' => 1,
                ]
            ),
            [
                'comment' => 'comment',
                'title' => 'title',
            ]
        );

        $response->assertStatus(200);
        $response->assertExactJson(
            [
                'result' => true,
                'response' => [
                    'todo_id' => $todoId->toArray(),
                ],
                'message' => 'Todo is made correctly',
            ]
        );

        $this->todoRepositoryMock
            ->shouldHaveReceived('createTodo')
            ->with(
                \Hamcrest\Matchers::equalTo(
                    new Todo(
                        new UserId(1),
                        'comment',
                        'title'
                    )
                )
            );
    }
}
