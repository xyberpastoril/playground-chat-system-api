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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('users', function(){
    return App\Models\User::all();
});

Route::group(['namespace' => 'Api\Auth'], function(){
    Route::post('/login', [\App\Http\Controllers\Api\Auth\AuthenticationController::class, 'login']);
    Route::post('/logout', [\App\Http\Controllers\Api\Auth\AuthenticationController::class, 'logout'])
        ->middleware('auth:api');
    Route::post('/register', [\App\Http\Controllers\Api\Auth\RegisterController::class, 'register']);
    Route::post('/forgot-password', [\App\Http\Controllers\Api\Auth\ForgotPasswordController::class, 'forgot']);
    Route::post('/reset-password', [\App\Http\Controllers\Api\Auth\ForgotPasswordController::class, 'reset']);
});
