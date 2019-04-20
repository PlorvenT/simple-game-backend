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
    Route::post('articles', 'Api\v1\ArticleController@store');

    Route::group(['middleware' => 'article'], function () {
        Route::get('articles/{article}', 'Api\v1\ArticleController@show');
        Route::put('articles/{article}', 'Api\v1\ArticleController@update');
        Route::delete('articles/{article}', 'Api\v1\ArticleController@delete');
    });

    //comment routes
    Route::get('comments', 'Api\v1\CommentController@index');
    Route::post('comments', 'Api\v1\CommentController@store');
    Route::get('comments/{comment}', 'Api\v1\CommentController@show');

    Route::group(['middleware' => 'comment'], function () {
        Route::put('comments/{comment}', 'Api\v1\CommentController@update');
        Route::delete('comments/{comment}', 'Api\v1\CommentController@delete');
    });
});

Route::group(['prefix' => 'v1'], function () {
    //auth routes
    Route::post('login', 'Api\v1\Auth\LoginController@login');
    Route::post('register', 'Api\v1\Auth\RegisterController@register');
});
