<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['prefix' => 'v1', 'namespace'=>'Api'],function ()
{

    Route::get('/organizations','OrganizationController@organizations');
    Route::get('get_organization/{id}','OrganizationController@getOrgainzation');

    Route::group(['middleware' => 'auth:api'],function (){

        Route::get('get_organization_user','OrganizationController@getOrganizationUser');
        Route::post('update_organization','OrganizationController@updateOrganization');
        
        Route::get('/organizations','OrganizationController@organizations');
        Route::get('/organization_product/{id}','OrganizationController@organizationProduct');

    });

});
