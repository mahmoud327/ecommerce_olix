<?php

use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;


Route::group(['prefix' => LaravelLocalization::setLocale(),
    'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ] , 'namespace' =>'Web\Admin' ], function()
{



    Route::group(['prefix' => 'admin','middleware' => 'auth:admins' ], function () {
        

        
        
        
        Route::resource('accounts', 'AccountController');
		Route::resource('sub_accounts', 'SubAccountController');
        
        Route::get('sub_account/{account_id}', 'AccountController@subAccounts')->name('sub_account');
        
		//routes control on filters from sub account module
		Route::get('filter_control_page/{id}', 'SubAccountController@filterControlPage')->name('filter_control_page'); //show page
		Route::post('change_filters/{id}', 'SubAccountController@changeFilters')->name('change_filters'); //oprations

		//routes control on features from sub account module
		Route::get('feature_control_page/{id}', 'SubAccountController@featureControlPage')->name('feature_control_page'); //show page
		Route::post('change_features/{id}', 'SubAccountController@changeFeatures')->name('change_features'); //oprations

		//routes control on categoris from sub account module
		Route::get('category_control_page/{id}', 'SubAccountController@categoryControlPage')->name('category_control_page'); //show page
		Route::post('change_categories/{id}', 'SubAccountController@changeCategories')->name('change_categories'); //oprations

    });

});