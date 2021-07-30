<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix'  =>  'v1', 'middleware' => ['api_auth'], 'namespace'   =>  'Api\V1'], function () {
    
    Route::get('/users', 'UsersController@index')->name('users.index');
    Route::get('/users/search', 'UsersController@search')->name('users.search');
});


// This Route jsut for testing the task
Route::get('get-new-key', 'Api\V1\ApiController@getNewKey');