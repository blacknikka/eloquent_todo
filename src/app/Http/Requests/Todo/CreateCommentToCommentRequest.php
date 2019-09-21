<?php

namespace App\Http\Requests\Todo;

use Illuminate\Foundation\Http\FormRequest;

class CreateCommentToCommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'todo_id' => [
                'required',
                'integer',
            ],
            'comment_id' => [
                'nullable',
                'integer',
            ],
            'comment' => [
                'required',
                'string',
            ],
        ];
    }

    /**
     * ルートパラメータをバリデーションするため、バリデーションデータをマージする
     *
     * @return array
     */
    protected function validationData(): array
    {
        return array_merge(
            $this->request->all(),
            [
                'todo_id' => $this->route('todo_id'),
                'comment_id' => $this->route('comment_id'),
            ]
        );
    }
}
