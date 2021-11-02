<?php

use Illuminate\Http\Request;


Route::group(['prefix' => 'products'], function () {

    Route::get('/', [
        'at' => 'products.all',
        'uses' => 'ProductController@index'
    ]);
    Route::get('/{id}', [
        'at' => 'products.show',
        'uses' => 'ProductController@show'
    ]);
    Route::post('/', [
        'at' => 'products.add',
        'uses' => 'ProductController@add',
         'middleware' => 'auth:api'
    ]);
});
Route::group(['prefix' => 'banner'], function () {

    Route::get('/', [
        'at' => 'banner.all',
        'uses' => 'BannerController@index'
    ]);
    Route::get('/{id}', [
        'at' => 'banner.show',
        'uses' => 'BannerController@show'
    ]);
    Route::post('/', [
        'at' => 'banner.add',
        'uses' => 'BannerController@add',
//        'middleware' => 'auth:api'
    ]);
});



Route::group(['prefix' => 'article'], function () {

    Route::get('/', [
        'at' => 'article.all',
        'uses' => 'ArticleController@index'
    ]);
    Route::get('/{id}', [
        'at' => 'article.show',
        'uses' => 'ArticleController@show'
    ]);
    Route::post('/', [
        'at' => 'article.add',
        'uses' => 'ArticleController@add',
//        'middleware' => 'auth:api'
    ]);
});





Route::post('/images', [
    'as' => 'images',
    'uses' => 'ImageController@create'
]);

Route::group(['prefix' => 'images'], function () {
    Route::get('/{productId}', [
        'at' => 'images.all',
        'uses' => 'ImageController@index'
    ]);
});

Route::group(['prefix' => 'users'], function () {

    Route::get('/', [
        'as' => 'users.all',
        'uses' => 'UserController@index'
    ]);
    //Register
    Route::post('/', [
        'as' => 'users',
        'uses' => 'UserController@store'
    ]);
});
Route::post('/login',[
    'as' => "login",
    'uses' => 'AuthController@login'
]);

Route::post('/logout',[
    'as' => 'logout',
    'uses' => 'AuthController@logout',
    'middleware' => 'auth:api'
]);
