<?php

namespace App\Http\Requests\Todo;

use Illuminate\Foundation\Http\FormRequest;

class GetTodoRequest extends FormRequest
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
            'id' => [
                'required',
                'integer',
            ]
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
                'id' => $this->route('id'),
            ]
        );
    }
}
