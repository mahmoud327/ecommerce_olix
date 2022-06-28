<?php

use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;


Route::group(['prefix' => LaravelLocalization::setLocale(),
    'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ] , 'namespace' =>'Web\Admin' ], function()
{



    Route::group(['prefix' => 'admin','middleware' => 'auth:admins' ], function () {

		// Route::resource('posts', 'PostController');
		// Route::get('post/{organization_id}', 'PostController@postOrganization')->name('post_organization');
		// Route::post('post/create', 'PostController@create');
		// Route::get('delete/post_image', 'PostController@delete_file');

     	// //store and delete image
		// Route::get('delete/post_image', 'PostController@delete_file');
		// Route::post('post_images', 'PostController@savePostImages')->name('admin.posts.images.store');

    });

});
