<?php

namespace Tests\Unit\Repositories;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Repositories\UserRepository;
use Mockery;
use App\Models\User\User;
use App\Models\User\UserId;
use App\Infrastructure\Eloquent\UserEloquent;

class UserRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /** @var UserRepository */
    private $sut;

    /** @var Mockery\MockInterface */
    private $userEloquentMock;

    public function setUp()
    {
        parent::setUp();

        // 依存をモックする
        $this->userEloquentMock = Mockery::mock(UserEloquent::class);

        // 注入
        app()->instance(UserEloquent::class, $this->userEloquentMock);

        // テスト対象のインスタンスを取得
        $this->sut = app()->make(UserRepository::class);
    }

    public function tearDown()
    {
        parent::tearDown();

        // close
        Mockery::close();
    }

    /** @test */
    public function UserEloquentのMockが呼ばれていることを確認()
    {
        $this->userEloquentMock
            ->shouldReceive('find')
            ->andReturn(null);

        $this->sut->findByUserId(new UserId(1));

        $this->userEloquentMock
            ->shouldHaveReceived('find');
    }

    /** @test */
    public function findByUserId_正常系()
    {
        $user = factory(UserEloquent::class)->create();
        $this->userEloquentMock
            ->shouldReceive('find')
            ->andReturn($user);

        $resultUser = $this->sut->findByUserId(new UserId($user->id));

        $this->userEloquentMock
            ->shouldHaveReceived('find');

        $this->assertSame($resultUser->getName(), $user->name);
        $this->assertSame($resultUser->getEmail(), $user->email);
        $this->assertSame($resultUser->getPassword(), $user->password);
    }

    /** @test */
    public function createUser_UserEloquentのcreateが呼ばれていること()
    {
        $user = factory(UserEloquent::class)->create();
        $this->userEloquentMock
            ->shouldReceive('create')
            ->andReturn($user);

        $this->sut->createUser(
            new User(
                $user->name,
                $user->email,
                $user->password
            )
        );

        $this->userEloquentMock
            ->shouldHaveReceived('create');

    }
}
