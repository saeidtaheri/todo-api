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
route::post('register', 'Api\AuthController@register');
route::post('login', 'Api\AuthController@login');


Route::group(['prefix' => 'api', 'middleware' => 'auth:api'], function() {
});
