<?php

use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;


Route::group(['prefix' => LaravelLocalization::setLocale(),
    'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ] , 'namespace' =>'Web\Admin' ], function()
{



    Route::group(['prefix' => 'admin','middleware' => 'auth:admins' ], function () {
        
        // organization type  module
	    Route::resource('organization_types', 'OrganizationTypeController');

        Route::get('organizations/index/{id}', 'OrganizationController@index')->name('organization.index');
        Route::get('organizations/create/{id}', 'OrganizationController@create')->name('organization.create');
        Route::resource('organizations', 'OrganizationController');
        Route::get('organizations_mobile', 'OrganizationController@organizations_mobile')->name('admin.organizations_mobile');
        Route::delete('organizations/destroy/all','OrganizationController@delete_all')->name('organizations.delete_all');

        // trash in organization
        Route::get('trash_organizations','OrganizationController@trash')->name('organizations.trash_organizations');
        Route::get('restore_organization/{id}','OrganizationController@restore')->name('organizations.restore_organization');
        Route::post('restore_organizations/restore_all','OrganizationController@restoreAll')->name('organizations.restore_all');
        Route::post('organizations/force_delete/{id}','OrganizationController@forceDestroy')->name('organizations.force_delete');
        Route::post('organizations/force_delete_all','OrganizationController@forceDestroyAll')->name('organizations.force_delete_all');

    });

});