<?php

use Illuminate\Http\Request;


Route::group(['prefix' => 'products'],function (){

    Route::get('/',[
        'at' => 'products.all',
        'uses' => 'ProductController@index'
    ]);
    Route::get('/{id}',[
        'at' => 'products.show',
        'uses' => 'ProductController@show'
    ]);
    Route::post('/',[
        'at' => 'products.add',
        'uses' => 'ProductController@add'
    ]);
});

Route::post('/images',[
   'as' => 'images',
   'uses' => 'ImageController@create'
]);

Route::group(['prefix' => 'images'],function (){
    Route::get('/{productId}',[
        'at' => 'images.all',
        'uses' => 'ImageController@index'
    ]);
});

Route::post('/users',[
   'as' => 'users',
    'uses' => 'UserController@store'
]);
Route::post('/admin',[
   'as' => 'admin',
    'uses' => 'UserController@store'
]);
