<?php

use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;


Route::group(['prefix' => LaravelLocalization::setLocale(),
    'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ] , 'namespace' =>'Web\Admin' ], function()
{



    Route::group(['prefix' => 'admin','middleware' => 'auth:admins' ], function () {
        
        Route::resource('marketers', 'MarketerController');
		Route::get('users_of_marketer/{markater_code_id?}', 'MarketerController@usersOfMarkaters')->name('users_of_marketer');
		Route::get('products_of_user_of_marketer/{markater_code_id}/{user_id}', 'MarketerController@ProductsOfUsersOfMarkaters')->name('products_of_user_of_marketer');

    });

});