<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['prefix' => 'v1', 'namespace'=>'Api'],function ()
{

    Route::post('register','UserController@register');
    Route::post('login','UserController@login');
    Route::post('social-register','SocialiteController@socialRegistration');
    Route::post('apple-register','SocialiteController@socialAppleRegistration');
    Route::post('reset_password','UserController@resetPassword');
    Route::post('verify_code','UserController@verify_code');
    Route::post('new_password','UserController@newPassword');
    Route::post('resend_user_verify_code','UserController@reSendCode');


    Route::group(['middleware' => 'auth:api'],function ()
    {
        Route::post('setMarketerCode','UserController@setMarketerCode');
        Route::post('logout','UserController@logout');
        Route::post('update_profile','UserController@profile');
        Route::post('update_password','UserController@update_password');
        Route::post('upgrade-request','UpgradeRequestController@upgrade_request');
    });
});