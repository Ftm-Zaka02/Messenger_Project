<?php

namespace App\Http\Requests\validator\messages;

use Illuminate\Foundation\Http\FormRequest;

class DeletePostRequest extends FormRequest
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
            'activeChatList' => 'nullable|max:255',
            'dataID' => 'nullable|max:3',
            'deleteType' => 'required|max:255',
        ];
    }
}
