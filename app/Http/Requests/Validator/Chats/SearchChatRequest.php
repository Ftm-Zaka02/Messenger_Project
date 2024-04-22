<?php

namespace App\Http\Requests\Validator\Chats;

use Illuminate\Foundation\Http\FormRequest;

class SearchChatRequest extends FormRequest
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
            'searchKey'=>'bail|required|max:50|string',
        ];
    }
}
