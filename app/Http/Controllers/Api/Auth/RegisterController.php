<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\Register\GenerateOTPRequest;
use App\Http\Requests\Api\Auth\Register\VerifyAndRegisterRequest;
use App\Mail\Auth\Register\SendOTPMail;
use App\Models\OneTimePassword;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    /**
     * Generates OTP and sends it to the user's email address.
     * 
     * @param GenerateOTPRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function generateOTP(GenerateOTPRequest $request)
    {
        // Get validated data from the request
        $validated = $request->validated();

        // Generate OTP
        $value = mt_rand(100000, 999999);

        // Delete existing OTP entry if there any
        OneTimePassword::whereEncrypted('email', $validated['email'])
            ->where('action', 'register')
            ->delete();

        // Store OTP Entry
        OneTimePassword::create([
            'email' => $validated['email'],
            'action' => 'register',
            'value' => Hash::make($value),
        ]);

        // Send OTP to the user's email address
        Mail::to($validated['email'])->send(new SendOTPMail($validated['name'], $validated['email'], $value));

        return response()->json([
            'message' => "OTP sent to {$validated['email']}."
        ], 200);
    }

    /**
     * TODO: Test Implementation
     * 
     * Verifies the OTP and registers the user.
     * 
     * @param VerifyAndRegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verifyAndRegister(VerifyAndRegisterRequest $request)
    {
        // Get validated data from the request
        $validated = $request->validated();

        // Get OTP from the database
        $otp = OneTimePassword::whereEncrypted('email', $validated['email'])
            ->where('action', 'register')
            ->first();
        
        // Check if the OTP exists and the OTP is valid
        if(!$otp || !Hash::check($validated['otp'], $otp->value)){
            return response()->json([
                'message' => 'Invalid OTP.',
            ], 422);
        }

        // Remove OTP from the database
        $otp->delete();

        // Register User
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Login User after registration
        $tokenName = 'AccessToken-' . $user->id . '-' . time();
        $token = $user->createToken($tokenName);

        return response()->json([
            'token' => [
                'access_token' => $token->accessToken,
                'expires_at' => $token->token->expires_at,
            ],
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
                'created_at' => $user->created_at,
            ],
            'message' => 'User successfully registered.',
        ], 200);
    }
}
