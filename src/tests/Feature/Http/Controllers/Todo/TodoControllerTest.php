<?php

namespace Tests\Feature\Http\Controllers\Todo;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Repositories\Todo\TodoRepository;
use App\Models\Todo\Todo;
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
        $this->todoRepositoryMock
            ->shouldReceive('getTodosByUserId')
            ->once()
            ->andReturn(
                collect(
                    [
                        new Todo(
                            new UserId(1),
                            'comment',
                            'title'
                        )
                    ]
                )
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

        $this->todoRepositoryMock
            ->shouldHaveReceived('getTodosByUserId')
            ->with(
                \Hamcrest\Matchers::equalTo(
                    new UserId(1)
                )
            );
    }
}
