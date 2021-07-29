<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix'  =>  'v1', 'namespace'   =>  'Api\V1'], function () {
    
    Route::get('/users', 'UsersController@index')->name('users.index');
    Route::get('/users/search', 'UsersController@search')->name('users.search');
});
