<?php

namespace Tests\Unit\Repositories;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Repositories\UserRepository;
use Mockery;
use App\Models\User\User;
use App\Models\User\UserId;
use App\Models\User\Profile;
use App\Models\User\ProfileId;
use App\Infrastructure\Eloquent\UserEloquent;
use App\Infrastructure\Eloquent\ProfileEloquent;

class UserRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /** @var UserRepository */
    private $sut;

    /** @var Mockery\MockInterface */
    private $userEloquentMock;

    /** @var Mockery\MockInterface */
    private $profileEloquentMock;

    public function setUp()
    {
        parent::setUp();

        // 依存をモックする
        $this->userEloquentMock = Mockery::mock(UserEloquent::class);
        $this->profileEloquentMock = Mockery::mock(ProfileEloquent::class);

        // 注入
        app()->instance(UserEloquent::class, $this->userEloquentMock);
        app()->instance(ProfileEloquent::class, $this->profileEloquentMock);

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

    /** @test */
    public function createUserProfile_existsが呼ばれていることの確認()
    {
        $this->userEloquentMock
            ->shouldReceive('where->exists')
            ->andReturn(false);

        $createResult = $this->sut->createUserProfile(
            new UserId(1),
            new Profile(
                new UserId(1),
                'displayName',
                'comment'
            )
        );

        $this->assertNull($createResult);
        $this->userEloquentMock
            ->shouldHaveReceived('where');
    }
}
