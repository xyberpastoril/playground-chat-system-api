<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\ForgotPasswordRequest;
use App\Http\Requests\Api\Auth\ResetPasswordRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function forgot(ForgotPasswordRequest $request)
    {
        $input = $request->validated();
        $email = $input['email'];
        $token = Str::random(10);

        
        DB::table('password_resets')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => now(),
        ]);
        // return $token;

        Mail::send('mail.password_reset_mail', ['token' => $token,], function($message) use($email){
            $message->from('noreply@example.com');
            $message->to($email);
            $message->subject('Reset Your Password');
        });

        return response()->json([
            'message' => 'Password reset link has been sent to your email.',
        ], 200);
    }

    public function reset(ResetPasswordRequest $request)
    {
        $validated = $request->except('password_confirmation');

        $user = User::where('email', $validated['email'])->first();
        $user->password = Hash::make($validated['password']);
        $user->save();

        DB::table('password_resets')->where('token', $validated['token'])->delete();

        return response()->json([
            'message' => 'Password has been reset successfully.',
        ], 200);
    }
}
