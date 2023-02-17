<?php

namespace App\Http\Requests\Api\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class ResetPasswordRequest extends FormRequest
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
            // add additional rule on the token field where the token is valid
            'token' => ['required','exists:password_resets,token'],
            'password' => ['required', 'min:6', 'confirmed'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            // Get token info from database and check if it is expired (validity is 1 hour since created_at)
            $reset = DB::table('password_resets')->where('token', $this->token)->first();

            if($reset) {
                $diff = now()->diffInMinutes($reset->created_at);
                if($diff > 60) {
                    $validator->errors()->add('token', 'This token is expired.');
                } else {
                    // Check if the user exists
                    $user = DB::table('users')->where('email', $reset->email)->first();
                    if (!$user) {
                        $validator->errors()->add('email', 'This email is not registered.');
                    } else {
                        $this->merge(['email' => $user->email]);
                    }
                }
            }
        });
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'token.required' => 'The token is required.',
            'token.exists' => 'This token is not valid.',
            'password.required' => 'The password field is required.',
            'password.confirmed' => 'The password confirmation does not match.',
        ];
    }
}
