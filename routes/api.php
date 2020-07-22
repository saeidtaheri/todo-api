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
//Test Login Route!!
route::get('login', function (){
    echo 'Your not Login!';
})->name('login');

route::post('register', 'Api\AuthController@register');
route::post('login', 'Api\AuthController@login');


//Route::group(['middleware' => 'auth:api'], function() {
    Route::get('logout', 'Api\AuthController@logout');
    Route::apiResource('projects', 'Api\ProjectController');
    Route::apiResource('todos', 'Api\TodoController');
//});
