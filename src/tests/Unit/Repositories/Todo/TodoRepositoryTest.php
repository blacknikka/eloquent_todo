<?php

namespace Tests\Unit\Repositories\Todo;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Repositories\Todo\TodoRepository;
use Mockery;
use App\Models\Todo\Todo;
use App\Models\Todo\TodoId;
use App\Models\User\UserId;
use App\Infrastructure\Eloquent\Todo\TodoEloquent;

class TodoRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /** @var TodoRepository */
    private $sut;

    /** @var Mockery\MockInterface */
    private $todoEloquentMock;

    public function setUp()
    {
        parent::setUp();

        // 依存をモックする
        $this->todoEloquentMock = Mockery::mock(TodoEloquent::class);

        // 注入
        app()->instance(TodoEloquent::class, $this->todoEloquentMock);

        // テスト対象のインスタンスを取得
        $this->sut = app()->make(TodoRepository::class);
    }

    public function tearDown()
    {
        parent::tearDown();

        // close
        Mockery::close();
    }

    /** @test */
    public function TodoEloquentのMockが呼ばれていることを確認()
    {
        $this->todoEloquentMock
            ->shouldReceive('find')
            ->andReturn(null);

        $this->sut->findByTodoId(new TodoId(1));

        $this->todoEloquentMock
            ->shouldHaveReceived('find');
    }

    /** @test */
    public function findByTodoId_正常系()
    {
        $todo = factory(TodoEloquent::class)->create();
        $this->todoEloquentMock
            ->shouldReceive('find')
            ->andReturn($todo);

        $findResultTodo = $this->sut->findByTodoId(new TodoId($todo->id));

        $this->todoEloquentMock
            ->shouldHaveReceived('find');

        $this->assertSame($findResultTodo->getUserId()->getId(), $todo->user->id);
        $this->assertSame($findResultTodo->getComment(), $todo->comment);
        $this->assertSame($findResultTodo->getTitle(), $todo->title);
    }

    /** @test */
    public function createTodo_TodoEloquentのcreateが呼ばれていること()
    {
        /** @var Todo $todo */
        $todo = factory(TodoEloquent::class)->create();
        $this->todoEloquentMock
            ->shouldReceive('create')
            ->andReturn($todo);

        $this->sut->createTodo(
            new Todo(
                new UserId($todo->user->id),
                $todo->comment,
                $todo->title
            )
        );

        $this->todoEloquentMock
            ->shouldHaveReceived('create');
    }
}
