<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

route::post('register', 'Api\AuthController@register');
route::post('login', 'Api\AuthController@login');

// Auth::routes(['verify' => true]);

Route::get('email/verify/{id}', 'Api\VerificationController@verify')->name('verification.verify');
Route::get('email/resend', 'Api\VerificationController@resend')->name('verification.resend');

Route::group(['middleware' => 'auth:api'], function() {
    Route::get('logout', 'Api\AuthController@logout');
    Route::apiResource('projects', 'Api\ProjectController');
    Route::apiResource('todos', 'Api\TodoController');
});
