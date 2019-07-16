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
    //hero routes
    Route::get('heroes', 'Api\v1\HeroController@index');
    Route::post('heroes', 'Api\v1\HeroController@store');

    //fighting routes
    Route::post('fight/attack-enemy', 'Api\v1\FightController@attackEnemy');
});

Route::group(['prefix' => 'v1'], function () {
    //auth routes
    Route::post('login', 'Api\v1\Auth\LoginController@login');
    Route::post('register', 'Api\v1\Auth\RegisterController@register');
});
