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
    Route::group([
        'middleware' => ['can:access dashboard'],
        'namespace' => 'Dashboard',
        'prefix' => 'dashboard'
    ], function () {
        Route::middleware(['role:root|admin'])->group(function () {
            Route::apiResource('users/admin', 'AdminController');
        });

        Route::apiResource('users', 'UserController');
    });

    Route::get('me', 'Auth\AuthController@me');

    Route::group(['namespace' => 'Api'], function () {
        Route::put('user', 'UserController@update');
    });

    // mobile
    Route::group([
        'namespace' => 'Auth',
        'prefix' => 'auth'
    ], function () {
        Route::post('logout', 'AuthController@logout');
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
