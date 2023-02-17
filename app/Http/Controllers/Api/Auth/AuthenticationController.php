<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        if(!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        /**
         * @var User $user
         */
        $user = Auth::user();
        $user->tokens->each(function($token) {
            $token->delete(); // Revoke past token of the user prior to creating a new one.
        });
    
        $tokenName = 'AccessToken-' . Auth::user()->id . '-' . time();
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
            ]
        ], 200);
    }

    public function logout()
    {
        /**
         * @var User $user
         */
        $user = Auth::guard('api')->user();
        $user->tokens->each(function($token) {
            $token->delete();
        });

        return response()->json([
            'message' => 'Successfully logged out.',
        ], 200);
    }
}
