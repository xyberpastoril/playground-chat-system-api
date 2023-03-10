<?php

namespace App\Http\Requests\Api\Messaging;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ReplyMessageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::guard('api')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'body' => ['required'],
        ];
    }

    public function withValidator($validator)
    {
        // Check if the authenticated user is a participant of the conversation
        $validator->after(function ($validator) {
            if (!$this->route('conversation')->participants->contains('user_id', Auth::id())) {
                $validator->errors()->add('conversation', 'You are not a participant of this conversation.');
            }
        });
    }
}
