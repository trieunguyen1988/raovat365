<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['namespace' => 'Admin', 'middleware' => ['admin'],'prefix' => 'admin'], function() {
	Route::get('/',
        ['uses' => 'IndexController@index']
    );

    Route::get('login',
        ['as' => 'admin.getAdminLogin', 'uses' => 'Auth\AuthController@login']
    );
    Route::post('login', 
    	['as' => 'admin.postAdminLogin', 'uses' => 'Auth\AuthController@login']
    );
});