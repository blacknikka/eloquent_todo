<?php

namespace Tests\Unit\Http\Requests\Todo;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Todo\GetCommentRequest;

class GetCommentRequestTest extends TestCase
{
    /** @var GetCommentRequest */
    private $sut;

    public function setUp()
    {
        parent::setUp();

        $this->sut = new GetCommentRequest();
    }

    /**
     * @test
     * @dataProvider dataProviderRules
     */
    public function validate_ruleの確認($id, $expect)
    {
        $rule = $this->sut->rules();

        $dataList = [
            'todo_id' => $id,
        ];
        $validator = Validator::make($dataList, $rule);
        $result = $validator->passes();
        $this->assertEquals($expect, $result);
    }

    public function dataProviderRules()
    {
        return [
            '正常'
                => [1, true],
            'id.型違い正常(文字は数値)'
                => ['1', true],
            'id.型違いエラー'
                => ['aaa', false],
            'id.nullエラー'
                => [null, false],
        ];
    }
}
