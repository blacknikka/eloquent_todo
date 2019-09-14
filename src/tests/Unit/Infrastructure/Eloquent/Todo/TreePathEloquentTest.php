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
        $this->assertTrue($treePath->ancestor_id > 0);
        $this->assertTrue($treePath->descendant_id > 0);
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
                'ancestor_id' => $ancestor->id,
                'descendant_id' => $decendant->id,
            ]
        );

        $this->assertTrue($created->ancestor_id > 0);
        $this->assertTrue($created->descendant_id > 0);
        $afterCount = TreePathEloquent::count();
        $this->assertSame($afterCount, $prevCount + 1);
    }

    /** @test */
    public function ancestor取得()
    {
        $ancestor = factory(CommentEloquent::class)->create();
        $descendant = factory(CommentEloquent::class)->create();

        $created = TreePathEloquent::create(
            [
                'ancestor_id' => $ancestor->id,
                'descendant_id' => $descendant->id,
            ]
        );

        $ancestorEloquent = $created->ancestor;
        $this->assertNotNull($ancestorEloquent);
        $this->assertSame($ancestorEloquent->id, $ancestor->id);

        $this->assertSame($ancestorEloquent->comment, $ancestor->comment);
    }

    /** @test */
    public function descendant取得()
    {
        $ancestor = factory(CommentEloquent::class)->create();
        $descendant = factory(CommentEloquent::class)->create();

        $created = TreePathEloquent::create(
            [
                'ancestor_id' => $ancestor->id,
                'descendant_id' => $descendant->id,
            ]
        );

        $descendantEloquent = $created->descendant;
        $this->assertNotNull($descendantEloquent);
        $this->assertSame($descendantEloquent->id, $descendant->id);

        $this->assertSame($descendantEloquent->comment, $descendant->comment);
    }
}
