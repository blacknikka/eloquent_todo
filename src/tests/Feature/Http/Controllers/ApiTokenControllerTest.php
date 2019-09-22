<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Repositories\UserRepositoryInterface;
use App\Infrastructure\Eloquent\UserEloquent;
use App\Models\User\UserId;
use Mockery;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Auth;

class ApiTokenControllerTest extends TestCase
{
    use WithoutMiddleware;

    /** @var Mockery\MockInterface */
    private $userRepositoryMock;

    public function setUp()
    {
        parent::setUp();

        // 依存をモックする
        $this->userRepositoryMock = Mockery::mock(UserRepositoryInterface::class);

        // 注入
        app()->instance(UserRepositoryInterface::class, $this->userRepositoryMock);
    }

    public function tearDown()
    {
        parent::tearDown();

        // close
        Mockery::close();
    }

    /** @test */
    public function updateApiToken_Authがnull()
    {
        // user非認証
        $response = $this->postJson(
            route(
                'updateApiToken'
            ),
            []
        );

        $response->assertStatus(200);
        $response->assertExactJson(
            [
                'token' => null,
            ]
        );
    }

    /** @test */
    public function updateApiToken_updateApiTokenがnullを返す()
    {
        $this->userRepositoryMock
            ->shouldReceive('updateApiToken')
            ->once()
            ->andReturn(null);

        $user = factory(UserEloquent::class)->create();
        // loginしたことにする
        $this->actingAs($user);
        $this->assertTrue(Auth::check());

        $response = $this->postJson(
            route(
                'updateApiToken'
            ),
            []
        );

        $response->assertStatus(200);
        $response->assertExactJson(
            [
                'token' => null,
            ]
        );

        $this->userRepositoryMock
            ->shouldHaveReceived('updateApiToken')
            ->with(
                \Hamcrest\Matchers::equalTo(
                    new UserId($user->id)
                )
            );
    }

    /** @test */
    public function updateApiToken_正常系()
    {
        $token = hash('sha256', Str::random(60));
        $this->userRepositoryMock
            ->shouldReceive('updateApiToken')
            ->once()
            ->andReturn($token);

        $user = factory(UserEloquent::class)->create();
        // loginしたことにする
        $this->actingAs($user);
        $this->assertTrue(Auth::check());

        $response = $this->postJson(
            route(
                'updateApiToken'
            ),
            []
        );

        $response->assertStatus(200);
        $response->assertExactJson(
            [
                'token' => $token,
            ]
        );

        $this->userRepositoryMock
            ->shouldHaveReceived('updateApiToken')
            ->with(
                \Hamcrest\Matchers::equalTo(
                    new UserId($user->id)
                )
            );
    }
}
