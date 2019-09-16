<?php

namespace Tests\Unit\Http\Requests\Todo;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Todo\SetTodoRequest;

class SetTodoRequestTest extends TestCase
{
    /** @var SetTodoRequest */
    private $sut;

    public function setUp()
    {
        parent::setUp();

        $this->sut = new SetTodoRequest();
    }

    /**
     * @test
     * @dataProvider dataProviderRules
     */
    public function validate_ruleの確認($id, $title, $comment, $expect)
    {
        $rule = $this->sut->rules();

        $dataList = [
            'id' => $id,
            'title' => $title,
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
                => [1, 'title', 'comment', true],
            'id.型違い正常(文字は数値)'
                => ['1', 'title', 'comment', true],
            'id.型違いエラー'
                => ['aaa', 'title', 'comment', false],
            'id.nullエラー'
                => [null, 'title', 'comment', false],
            'title.empty'
                => [1, '', 'comment', true],
            'title.型違いエラー'
                => [1, 1, 'comment', false],
            'title.nullエラー'
                => [1, null, 'comment', false],
            'comment.empty'
                => [1, 'title', '', true],
            'comment.型違いエラー'
                => [1, 'title', 1, false],
            'comment.nullエラー'
                => [1, 'title', null, false],
        ];
    }
}
