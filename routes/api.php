<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'namespace' => 'Api\Auth',
    'as' => 'auth.',
    'prefix' => '/auth',
], function(){
    Route::post('/login', [\App\Http\Controllers\Api\Auth\AuthenticationController::class, 'login']);
    Route::post('/logout', [\App\Http\Controllers\Api\Auth\AuthenticationController::class, 'logout'])
        ->middleware('auth:api');
    Route::post('/forgot', [\App\Http\Controllers\Api\Auth\ForgotPasswordController::class, 'forgot']);
    Route::post('/reset', [\App\Http\Controllers\Api\Auth\ForgotPasswordController::class, 'reset']);

    Route::group([
        'as' => 'register.',
        'prefix' => '/register',
    ], function(){
        Route::post('/generate-otp', [\App\Http\Controllers\Api\Auth\RegisterController::class, 'generateOTP']);
        Route::post('/verify', [\App\Http\Controllers\Api\Auth\RegisterController::class, 'verifyAndRegister']);
    });
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('users', function(){
    return App\Models\User::all();
});

Route::group([
    'middleware' => 'auth:api',
], function(){

    // Search User
    Route::get('search/user/{name}', function($name){
        return App\Models\User::where('name', 'like', '%'.$name.'%')->get();
    });

    // Messaging
    Route::post('/messaging/conversation/create', [\App\Http\Controllers\Api\Messaging\ConversationController::class, 'create']);
    Route::get('/messaging/conversation/get/{conversation}', [\App\Http\Controllers\Api\Messaging\ConversationController::class, 'get']);
    Route::post('/messaging/conversation/reply/{conversation}', [\App\Http\Controllers\Api\Messaging\ConversationController::class, 'reply']);

});

