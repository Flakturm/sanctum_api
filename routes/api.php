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
        'middleware' => ['can:browse dashboard'],
        'namespace' => 'Dashboard',
        'prefix' => 'dashboard'
    ], function () {
        Route::middleware(['can:access users.admin'])->group(function () {
            Route::apiResource('users/admin', 'AdminController');
            Route::get('roles', 'RoleController@index');
        });

        Route::middleware(['can:access users.permissions'])->group(function () {
            Route::apiResource('roles', 'RoleController')->except(['index']);
            Route::get('permissions', 'PermissionController@index');
        });

        Route::apiResource('users/members', 'MemberController');
        Route::apiResource('users/vendors', 'VendorController');
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
