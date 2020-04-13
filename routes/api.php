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

Route::post("signup", "Auth\AuthController@signUp")->name("signUp");
Route::post("login", "Auth\AuthController@logIn")->name("logIn");

Route::group(['middleware' => ['auth:api']], function () {
    Route::post("logout", "Auth\AuthController@logOut")->name("logOut");
    Route::group(['middleware' => 'admin', 'prefix' => 'admin'], function () {
        Route::patch('articles/{article}/delete','Admin\ArticleController@delete')->name('articles.delete');
        Route::patch('articles/{id}/restore','Admin\ArticleController@restore')->name('articles.restore');
        Route::patch('articles/{article}/approve','Admin\ArticleController@approve')->name('articles.approve');
        Route::get('articles/trashed','Admin\ArticleController@trashed')->name('articles.trashed');
        Route::apiResource('articles', 'Admin\ArticleController');
    });
});
