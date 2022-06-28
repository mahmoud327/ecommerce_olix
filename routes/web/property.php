<?php

use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;


Route::group(['prefix' => LaravelLocalization::setLocale(),
    'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ] , 'namespace' =>'Web\Admin' ], function()
{



    Route::group(['prefix' => 'admin','middleware' => 'auth:admins' ], function () {
        

		Route::resource('properties', 'PropertyController');

		// product sub property module 
		Route::get('sub_properties/index/{id}', 'SubPropertyController@index')->name('sub_property.index');
		Route::get('properties/get_sub_properties/{id}', 'SubPropertyController@getSubProperties');
		Route::resource('sub_properties', 'SubPropertyController');

    });

});