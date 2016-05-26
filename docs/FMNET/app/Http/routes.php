<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    Route::get('logout', function(){
        Auth::logout();
        return redirect('login');
    });
    Route::get('',
        ['middleware' => 'auth:web', 'as' => 'user.userEdit', 'uses' => 'UserController@edit']);
    Route::get('user/register',
        ['as' => 'user.getUserRegister', 'uses' => 'UserController@register']);
    Route::get('user/cmail',
        ['as' => 'user.getUserChangeMail', 'uses' => 'UserController@changeMail']);
    Route::post('user/register',
        ['as' => 'user.postUserRegister', 'uses' => 'UserController@register']);
    Route::get('login',
        ['as' => 'user.getUserLogin', 'uses' => 'Auth\AuthController@login']);
    Route::post('login',
        ['as' => 'user.postUserLogin', 'uses' => 'Auth\AuthController@login']);
    Route::get('user/edit',
        ['middleware' => 'auth:web', 'as' => 'user.getUserEdit', 'uses' => 'UserController@edit']);
    Route::post('user/edit',
        ['middleware' => 'auth:web', 'as' => 'user.postUserEdit', 'uses' => 'UserController@edit']);
    Route::get('user/temp_register',
        ['as' => 'user.getUserTempRegister', 'uses' => 'UserController@tempRegister']);
    Route::post('user/temp_register',
        ['as' => 'user.postUserTempRegister', 'uses' => 'UserController@tempRegister']);
    Route::get('shop',
        ['middleware' => 'auth:web', 'as' => 'shop.getShop', 'uses' => 'ShopController@index']);
    Route::get('shop/create',
        ['middleware' => 'auth:web', 'as' => 'shop.getShopCreate', 'uses' => 'ShopController@create']);
    Route::post('shop/create',
        ['middleware' => 'auth:web', 'as' => 'shop.postShopCreate', 'uses' => 'ShopController@create']);
    Route::get('shop/edit',
        ['middleware' => 'auth:web', 'as' => 'shop.getShopEdit', 'uses' => 'ShopController@edit']);
    Route::post('shop/edit',
        ['middleware' => 'auth:web', 'as' => 'shop.postShopEdit', 'uses' => 'ShopController@edit']);
    Route::get('inquiry',
        ['middleware' => 'auth:web', 'as' => 'inquiry.getInquiryCreate', 'uses' => 'InquiryController@create']);
    Route::post('inquiry',
        ['middleware' => 'auth:web', 'as' => 'inquiry.postInquiryCreate', 'uses' => 'InquiryController@create']);
    Route::get('inquiry/finish',
        ['middleware' => 'auth:web', 'as' => 'inquiry.getInquiryFinish', 'uses' => 'InquiryController@finish']);
    Route::get('user/payment',
        ['middleware' => 'auth:web', 'as' => 'user.getUserPayment', 'uses' => 'UserController@payment']);
    Route::post('user/payment',
        ['middleware' => 'auth:web', 'as' => 'user.postUserPayment', 'uses' => 'UserController@payment']);
    Route::post('user/payment_confirm',
        ['middleware' => 'auth:web', 'as' => 'user.postUserPaymentConfirm', 'uses' => 'UserController@paymentConfirm']);
    Route::post('user/payment_finish',
        ['middleware' => 'auth:web', 'as' => 'user.postUserPaymentFinish', 'uses' => 'UserController@paymentFinish']);
    Route::get('user/reset_password',
        ['as' => 'user.getUserResetPassword', 'uses' => 'UserController@resetPassword']);
    Route::post('user/reset_password',
        ['as' => 'user.postUserResetPassword', 'uses' => 'UserController@resetPassword']);
    Route::get('user/change_password',
        ['as' => 'user.getUserChangePassword', 'uses' => 'UserController@changePassword']);
    Route::post('user/change_password',
        ['as' => 'user.getUserChangePassword', 'uses' => 'UserController@changePassword']);
});
Route::group(['middleware' => ['api']], function () {
    Route::post('api/v1/users/login',
        ['as' => 'api.userLogin', 'uses' => 'Api\v1\UserController@userLogin']);
    Route::post('api/v1/users/register',
        ['as' => 'api.userRegister', 'uses' => 'Api\v1\UserController@userRegister']);
    Route::post('api/v1/playlist/add',
        ['as' => 'api.playlistAdd', 'uses' => 'Api\v1\PlaylistController@playlistAdd']);
    Route::post('api/v1/playlist/update',
        ['as' => 'api.playlistUpdate', 'uses' => 'Api\v1\PlaylistController@playlistUpdate']);
    Route::post('api/v1/playlist/delete',
        ['as' => 'api.playlistDelete', 'uses' => 'Api\v1\PlaylistController@playlistDelete']);
    Route::post('api/v1/schedule/add',
        ['as' => 'api.scheduleAdd', 'uses' => 'Api\v1\ScheduleController@scheduleAdd']);
    Route::post('api/v1/schedule/update',
        ['as' => 'api.scheduleUpdate', 'uses' => 'Api\v1\ScheduleController@scheduleUpdate']);
    Route::post('api/v1/schedule/delete',
        ['as' => 'api.scheduleDelete', 'uses' => 'Api\v1\ScheduleController@scheduleDelete']);
});
Route::group(['namespace' => 'Admin', 'middleware' => ['admin'],'prefix' => 'admin'], function() {
    Route::get('login',
        ['as' => 'admin.getUserLogin', 'uses' => 'Auth\AuthController@login']);
    Route::post('login',
        ['as' => 'admin.postUserLogin', 'uses' => 'Auth\AuthController@login']);
    Route::get('user',
        ['as' => 'admin.getUserEdit', 'uses' => 'UserController@index']);
    Route::get('user/download',
        ['as' => 'admin.getUserDownload', 'uses' => 'UserController@download']);    
    Route::post('user',
        ['as' => 'admin.postUserEdit', 'uses' => 'UserController@index']);
    Route::get('user/edit',
        ['as' => 'admin.getUserEdit', 'uses' => 'UserController@edit']);
    Route::post('user/edit',
        ['as' => 'admin.postUserEdit', 'uses' => 'UserController@edit']);
    Route::post('user/delete',
        ['as' => 'admin.postUserDelete', 'uses' => 'UserController@delete']);    
    Route::get('shop',
        ['as' => 'shop.getShop', 'uses' => 'ShopController@index']);
    Route::get('shop/edit',
        ['as' => 'shop.getShopEdit', 'uses' => 'ShopController@edit']);
    Route::post('shop/edit',
        ['as' => 'shop.postShopEdit', 'uses' => 'ShopController@edit']);  
    Route::get('account',
        ['as' => 'admin.getAccount', 'uses' => 'AccountController@index']);
    Route::post('account',
        ['as' => 'admin.postAccount', 'uses' => 'AccountController@index']);    
    Route::get('account/reset_password',
        ['as' => 'account.getAccountResetPassword', 'uses' => 'AccountController@resetPassword']);
    Route::post('account/reset_password',
        ['as' => 'account.postAccountResetPassword', 'uses' => 'AccountController@resetPassword']);    
});