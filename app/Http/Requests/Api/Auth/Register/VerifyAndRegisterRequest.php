<?php

namespace App\Http\Requests\Api\Auth\Register;

use Illuminate\Foundation\Http\FormRequest;

class VerifyAndRegisterRequest extends FormRequest
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
            'otp' => ['required', 'min:6', 'max:6'],
            
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:6', 'confirmed'],
            
            'first_name' => ['required'],
            'last_name' => ['required'],
            'contact_number' => ['required'],

            'barangay_id' => ['required', 'numeric'],
            'house_lot_number' => ['sometimes'],
            'street' => ['sometimes'],
            'village_subdivision' => ['sometimes'],
            'unit_floor' => ['sometimes'],
            'building' => ['sometimes'],
        ];
    }
}
