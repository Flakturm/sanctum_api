<?php

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

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::group(['namespace' => 'Api'], function () {
        Route::get('user', 'UserController@index');
        Route::put('user', 'UserController@update');
    });

    Route::group(['prefix' => 'auth'], function () {
        Route::post('logout', 'Auth\AuthController@logout');
    });
});

Route::group([
    'namespace' => 'Auth',
    'prefix' => 'auth'
], function () {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
});

Auth::routes();
