<?php

namespace App\Http\Requests\Validator\Messages;

use Illuminate\Foundation\Http\FormRequest;

class DeleteMessageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    protected $stopOnFirstFailure = true;

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
            'chatListName' => 'bail|nullable|max:255|string',
            'dataID' => 'bail|nullable|exists:messages,id',
            'deleteType' => 'bail|required|max:255',
        ];
    }
}
