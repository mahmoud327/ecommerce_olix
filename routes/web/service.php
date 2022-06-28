<?php

use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;


Route::group(['prefix' => LaravelLocalization::setLocale(),
    'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ] , 'namespace' =>'Web\Admin' ], function()
{



    Route::group(['prefix' => 'admin','middleware' => 'auth:admins' ], function () {
        
        Route::resource('services', 'ServiceController');
        Route::resource('service_requests', 'ServiceRequestController');
        Route::delete('services/destroy/all','ServiceController@delete_all')->name('services.delete_all');
        Route::resource('organization_services', 'OrganizationServiceController');
        Route::delete('organization_services/destroy/all','OrganizationServiceController@delete_all')->name('organization_services.delete_all');
        Route::post('organization_services/sortabledatatable', 'OrganizationServiceController@sortable')->name('sortable');

    });

});