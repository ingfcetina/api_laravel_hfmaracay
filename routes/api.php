<?php

use Illuminate\Http\Request;

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

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');

    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('logout', 'AuthController@logout');
        Route::get('usuarios', 'Admin\UserController@index');
        Route::get('usuario/{user}', 'Admin\UserController@show');
        Route::patch('/usuarios/{user}/trash', 'Admin\UserController@delete')->where('user', '[0-9]+');
        Route::delete('usuarios/{id}/destroy','Admin\UserController@destroy')->where('id', '[0-9]+');

        Route::get('pictures', 'PictureController@get');
        Route::post('pictures', 'PictureController@post');
        Route::get('pictures/{id}', 'PictureController@show')->where('id', '\d+');
        Route::patch('pictures/{id}', 'PictureController@patch')->where('id', '\d+');
        Route::delete('pictures/{id}', 'PictureController@delete')->where('id', '\d+');
    });
});
