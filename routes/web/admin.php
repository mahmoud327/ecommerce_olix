<?php

use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;


Route::group(['prefix' => LaravelLocalization::setLocale(),
    'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ] , 'namespace' =>'Web\Admin' ], function()
{



    Route::get('/login','AuthController@login')->name('admin.login');
    Route::post('/checkout_login','AuthController@loginCheck')->name('admin.loginCheck');

    //  Route::get('copy_cities',function()
    //  {

    //  $organization_services_cities_name=\App\Models\OrganizationService::where('city_name','!=','')->get();

    //  foreach($organization_services_cities_name  as  $organization_services_city_name)
    //  {

    //        $city = \App\Models\City::whereRaw('LOWER(`name`) like ?', ['%'.($organization_services_city_name->city_name).'%'])->orwhere('name->ar','LIKE', '%'. $organization_services_city_name->city_name .'%')->first();
    //        if( $city )
    //        {
    
    //             //  $products_cities_name->update['city_id' => $city->id];
    //               $organization_services_city_name->update([ 'city_id' => $city->id ]);

    //        }


    //     //  $city_id=\App\Models\City::where('name',(string)$product_city_name->city_name )->toSql();


    //     // $products_cities_name->save();

    //  }
    //  return 'dd';

     
    //  });

    Route::group(['prefix' => 'admin','middleware' => 'auth:admins' ], function () {

        // admin services
        Route::resource('admins','AdminController');
        Route::get('/logout','AuthController@logout')->name('admin.logout');
        Route::get('admins-activate/{id}', 'AdminController@activate')->name('admins.activate');
        Route::get('admins-deactivate/{id}', 'AdminController@deactivate')->name('admins.deactivate');
        Route::delete('admins/destroy/all','AdminController@delete_all')->name('admins.delete_all');
        Route::delete('admins/roles/destroy/all','RoleController@delete_all')->name('admins.roles.delete_all');
        Route::get('delete/image', 'AdminController@delete_file');
        Route::post('admin_images', 'AdminController@saveAdminImages')->name('admin.admins.images.store');

        //save image dropzone
        Route::resource('roles','RoleController');
    });

});