<?php

namespace Tests\Unit\Http\Requests\Todo;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Todo\CreateCommentToCommentRequest;

class CreateCommentToCommentRequestTest extends TestCase
{
    /** @var CreateCommentToCommentRequest */
    private $sut;

    public function setUp()
    {
        parent::setUp();

        $this->sut = new CreateCommentToCommentRequest();
    }

    /**
     * @test
     * @dataProvider dataProviderRules
     */
    public function validate_ruleの確認($todo_id, $comment_id, $comment, $expect)
    {
        $rule = $this->sut->rules();

        $dataList = [
            'todo_id' => $todo_id,
            'comment_id' => $comment_id,
            'comment' => $comment,
        ];
        $validator = Validator::make($dataList, $rule);
        $result = $validator->passes();
        $this->assertEquals($expect, $result);
    }

    public function dataProviderRules()
    {
        return [
            '正常'
                => [1, 1, 'comment', true],
            'todo_id.型違い正常(文字は数値)'
                => ['1', 1, 'comment', true],
            'todo_id.型違いエラー'
                => ['aaa', 1, 'comment', false],
            'todo_id.nullエラー'
                => [null, 1, 'comment', false],
            'comment_id.型違い正常(文字は数値)'
                => [1, '1', 'comment', true],
            'comment_id.型違いエラー'
                => [1, 'aaa', 'comment', false],
            'comment_id.null ok'
                => [1, null, 'comment', true],
            'comment.emptyエラー'
                => [1, 1, '', false],
            'comment.型違いエラー'
                => [1, 1, 1, false],
            'comment.nullエラー'
                => [1, 1, null, false],
        ];
    }
}
