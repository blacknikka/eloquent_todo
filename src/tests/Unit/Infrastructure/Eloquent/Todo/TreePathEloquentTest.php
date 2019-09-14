<?php

namespace Tests\Unit\Infrastructure\Eloquent\Todo;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Infrastructure\Eloquent\Todo\CommentEloquent;
use App\Infrastructure\Eloquent\Todo\TreePathEloquent;

class TreePathEloquentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function factoryテスト()
    {
        $count = TreePathEloquent::count();
        $treePath = factory(TreePathEloquent::class)->create();
        $this->assertSame($count + 1, TreePathEloquent::count());
        $this->assertTrue($treePath->ancestor > 0);
        $this->assertTrue($treePath->descendant > 0);
    }

    /** @test */
    public function Create()
    {
        $prevCount = TreePathEloquent::count();

        // 外部キー用のデータを作成
        $ancestor = factory(CommentEloquent::class)->create();
        $decendant = factory(CommentEloquent::class)->create();

        $created = TreePathEloquent::create(
            [
                'ancestor' => $ancestor->id,
                'descendant' => $decendant->id,
            ]
        );

        $afterCount = TreePathEloquent::count();
        $this->assertTrue($created->ancestor > 0);
        $this->assertTrue($created->descendant > 0);
        $this->assertSame($afterCount, $prevCount + 1);
    }
}
