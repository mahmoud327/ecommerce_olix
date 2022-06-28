<?php

use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;


Route::group(['prefix' => LaravelLocalization::setLocale(),
    'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ] , 'namespace' =>'Web\Admin' ], function()
{



    Route::group(['prefix' => 'admin','middleware' => 'auth:admins' ], function () {
        
        Route::resource('advertisments', 'AdvertismentController');
        Route::get('advertisments/index/{category_id}', 'AdvertismentController@index')->name('advertisments.index');
        Route::get('advertisments/create/{category_id}', 'AdvertismentController@create')->name('advertisments.create');
        Route::delete('advertisments/destroy/all','AdvertismentController@delete_all')->name('advertisments.delete_all');
        Route::get('delete/advertisment_image', 'AdvertismentController@delete_file');
        Route::post('images_advertisment', 'AdvertismentController@saveaAvertismentImages')->name('admin.advertisment.images.store');

    });

});