<?php

namespace App\Http\Requests\Validator\Messages;

use Illuminate\Foundation\Http\FormRequest;

class GetMessageRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'page'=>'bail|required',
            'chatID'=>'bail|required|exists:chats,id'
        ];
    }
}
