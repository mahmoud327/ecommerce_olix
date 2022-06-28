<?php

use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;


Route::group(['prefix' => LaravelLocalization::setLocale(),
    'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ] , 'namespace' =>'Web\Admin' ], function()
{
     //paginiate ajax
  
    Route::get('pagination/fetch_data', 'UserController@fetch_data');
    Route::group(['prefix' => 'admin','middleware' => 'auth:admins' ], function () {
        

        Route::resource('users', 'UserController');
		Route::get('user-activate/{id}', 'UserController@active')->name('user.activate');
        Route::get('user-deactivate/{id}', 'UserController@deactivate')->name('user.deactivate');
		Route::delete('users/destroy/all','UserController@delete_all')->name('users.delete_all');
		Route::get('user/delete/{id}','UserController@destroy');
		Route::post('user_upgrade/{id}', 'UserController@update')->name('user_upgrade');
        


        // upgrade request module
        Route::get('upgrade_requests', 'UpgradeRequestController@index')->name('upgrade_requests.index');
        Route::get('upgrade_requests/show/{id}', 'UpgradeRequestController@show')->name('upgrade_requests.show');
        Route::post('upgrade_requests/rejected/{id}', 'UpgradeRequestController@rejected')->name('upgrade_requests.rejected');
        Route::post('upgrade_requests/accepted/{id}', 'UpgradeRequestController@acceptd')->name('upgrade_requests.accepted');

        Route::get('products_of_user/{user_id}', 'UserController@productOfUser')->name('users.products_of_user');
        Route::get('/live_search/action', 'UserController@action')->name('live_search.action');
        Route::get('/search/users', 'UserController@search')->name('user.search');
        Route::Post('/user/send_notification/{user_id}', 'UserController@sendNotification')->name('user.send_notification');
        Route::Post('/users/send_notification_all_user', 'UserController@sendNotificationAllUser')->name('users.send_notification_all_users');



    });

});