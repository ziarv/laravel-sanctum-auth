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

Route::group(['namespace' => 'Api'], function () {
    // public routes
    Route::post('/user/register', [
        'uses' => 'UsersController@registerAction',
        'as' => 'api.user.register',
    ]);
    Route::post('/user/login', [
        'uses' => 'UsersController@loginAction',
        'as' => 'api.user.login',
    ]);
    // protected routes
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::get('/user/me', [
            'uses' => 'UsersController@meAction',
            'as' => 'api.user.me',
        ]);
        Route::post('/user/logout', [
            'uses' => 'UsersController@logoutAction',
            'as' => 'api.user.logout',
        ]);
    });
});
