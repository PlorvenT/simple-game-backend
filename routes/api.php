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

Route::group(['prefix' => 'v1', 'middleware' => 'auth:api'], function () {
    //article routes
    Route::get('articles', 'Api\v1\ArticleController@index');
    Route::get('articles/{article}', 'Api\v1\ArticleController@show');
    Route::post('articles', 'Api\v1\ArticleController@store');
    Route::put('articles/{article}', 'Api\v1\ArticleController@update');
    Route::delete('articles/{article}', 'Api\v1\ArticleController@delete');
});



Route::group(['prefix' => 'v1'], function () {
    //auth routes
    Route::post('login', 'Api\v1\Auth\LoginController@login');
    Route::post('register', 'Api\v1\Auth\RegisterController@register');
});
