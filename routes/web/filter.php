<?php

use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;


Route::group(['prefix' => LaravelLocalization::setLocale(),
    'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ] , 'namespace' =>'Web\Admin' ], function()
{



    Route::group(['prefix' => 'admin','middleware' => 'auth:admins' ], function () {
        
        //filters module
        Route::get('filters/{category_id}', 'FilterController@index')->name('filters.index');
        Route::post('filters/store/{category_id}', 'FilterController@store')->name('filters.store');
        Route::post('filters/update/{id}', 'FilterController@update')->name('filters.update');
        Route::post('filters/destroy/{id}', 'FilterController@destroy')->name('filters.destroy');

        // trash in filter
        Route::get('trash_filter/{cat_id}','FilterController@trash')->name('filters.trash_filter');
        Route::get('restore_filters/{cat_id}','FilterController@restore')->name('filters.restore_filter');
        Route::post('restore_filters/restore_all','FilterController@restoreAll')->name('filters.restore_all');
        Route::post('filters/force_delete/{id}','FilterController@forceDestroy')->name('filters.force_delete');
        Route::post('filters/force_delete_all','FilterController@forceDestroyAll')->name('filters.force_delete_all');

        //save image dropzone
        Route::post('images_filters', 'FilterController@saveFilterImages')->name('admin.filters.images.store');

        //sub filters module
        Route::get('sub_filters/{filter_id}', 'SubFilterController@index')->name('sub_filters.index');
        Route::post('sub_filters/store/{filter_id}', 'SubFilterController@store')->name('sub_filters.store');
        Route::post('sub_filters/update/{id}', 'SubFilterController@update')->name('sub_filters.update');
        Route::post('sub_filters/destroy/{id}', 'SubFilterController@destroy')->name('sub_filters.destroy');

        // trash in sub filter
        Route::get('trash_sub_filters/{filter_id}','SubFilterController@trash')->name('sub_filters.trash_sub_filter');
        Route::get('restore_sub_filters/{filter_id}','SubFilterController@restore')->name('sub_filters.restore_sub_filter');
        Route::post('restore_sub_filters/restore_all','SubFilterController@restoreAll')->name('sub_filters.restore_all');
        Route::post('sub_filters/force_delete/{id}','SubFilterController@forceDestroy')->name('sub_filters.force_delete');
        Route::post('sub_filters/force_delete_all','SubFilterController@forceDestroyAll')->name('sub_filters.force_delete_all');

        //save image dropzone
        Route::post('images_sub_filters', 'SubFilterController@saveSubFilterImages')->name('admin.sub_filters.images.store');
        
        /*********************** */

        // filter type  module
		Route::resource('filter_types', 'FilterTypeController');

		// recurring filters  module
		Route::get('recurring_filters/index/{id}', 'RecurringFilterController@index')->name('recurring_filter.index');
		Route::get('recurring_filters/create/{id}', 'RecurringFilterController@create')->name('recurring_filter.create');
		// Route::get('category/sub_category_tree', 'RecurringFilterController@subCategoryInTree')->name('category.sub_category_tree');
		// Route::get('category/childs_categories_tree', 'RecurringFilterController@childsCategoriesInTree')->name('category.childs_categories_tree');

		Route::resource('recurring_filters', 'RecurringFilterController');

		// trash in recurring filter
		Route::get('trash_recurring_filters/{filter_type_id}','RecurringFilterController@trash')->name('recurring_filters.trash_recurring_filter');
		Route::get('restore_recurring_filters/{id}','RecurringFilterController@restore')->name('recurring_filters.restore_recurring_filter');
		Route::post('restore_recurring_filters/restore_all','RecurringFilterController@restoreAll')->name('recurring_filters.restore_all');
		Route::post('recurring_filters/force_delete/{id}','RecurringFilterController@forceDestroy')->name('recurring_filters.force_delete');
		Route::post('recurring_filters/force_delete_all','RecurringFilterController@forceDestroyAll')->name('recurring_filters.force_delete_all');
		Route::post('filter_sortabledatatable', 'RecurringFilterController@sortable')->name('filter_sortabledatatable');
		

		// store and delete
		Route::get('delete/recurring_filters', 'RecurringFilterController@delete_file');
		Route::post('images_recurring_filters', 'RecurringFilterController@saveRecuringFilterImages')->name('admin.recurring_filters.images.store');
		Route::post('admin_recurring_filters_update', 'RecurringFilterController@UpdateRecuringFilterImages')->name('admin_recurring_filters_update');

		// recurring sub filters  module
		Route::get('recurring_sub_filters/{id}', 'RecurringSubFilterController@subFilters')->name('recurring_sub_filters');
		Route::resource('recurring_sub_filters', 'RecurringSubFilterController');


		// trash in recurring sub filter
		Route::get('trash_recurring_sub_filters/{filter_recurring_id}','RecurringSubFilterController@trash')->name('recurring_sub_filters.trash_recurring_sub_filter');
		Route::get('restore_recurring_sub_filters/{id}','RecurringSubFilterController@restore')->name('recurring_sub_filters.restore_recurring_sub_filter');
		Route::post('restore_recurring_sub_filters/restore_all','RecurringSubFilterController@restoreAll')->name('recurring_sub_filters.restore_all');
		Route::post('recurring_sub_filters/force_delete/{id}','RecurringSubFilterController@forceDestroy')->name('recurring_sub_filters.force_delete');
		Route::post('recurring_sub_filters/force_delete_all','RecurringSubFilterController@forceDestroyAll')->name('recurring_sub_filters.force_delete_all');
		Route::post('sub_filter_sortabledatatable', 'RecurringSubFilterController@sortable')->name('sub_filter_sortabledatatable');

		// store and delete
		Route::post('images_recurring_sub_filters', 'RecurringSubFilterController@saveRecuringSubFilterImages')->name('admin.recurring_sub_filters.images.store');

    });

});