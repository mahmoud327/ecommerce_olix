<?php

use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;


Route::group(['prefix' => LaravelLocalization::setLocale(),
    'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ] , 'namespace' =>'Web\Admin' ], function()
{



    Route::group(['prefix' => 'admin','middleware' => 'auth:admins' ], function () {
         ///paginate ajax
        Route::get('categories/pagination/fetch_data', 'CategoryController@fetch_data');
        Route::get('sub-categories/pagination/fetch_data', 'CategoryController@fetch_data_subCategories');
        Route::get('search_subCategories/pagination/fetch_data', 'CategoryController@subCategoriesResult');

        // category type  module
        Route::resource('category_types', 'CategoryTypeController');

        // categories module
        Route::resource('categories', 'CategoryController');
        Route::get('categoriesstore', 'CategoryController@dtoredata');
        Route::get('categories_parent_search', 'CategoryController@serachParentCategory')->name('serachParentCategory');
        Route::get('search_subCategories', 'CategoryController@serachSubCategory')->name('search_subCategories');
        Route::post('sortabledatatable', 'CategoryController@sortable')->name('sortable');
        Route::delete('categories/destroy/all','CategoryController@delete_all')->name('categories.delete_all');

        // trash in category
        Route::get('trash_catrgory/{id?}','CategoryController@trash')->name('category.trash_catrgory');
        Route::get('restore_category/{id}','CategoryController@restore')->name('category.restore_category');
        Route::post('restore_category/restore_all','CategoryController@restoreAll')->name('category.restore_all');
        Route::post('category/force_delete/{id}','CategoryController@forceDestroy')->name('category.force_delete');
        Route::post('category/force_delete_all','CategoryController@forceDestroyAll')->name('category.force_delete_all');

        //image drop zone for recuring and sub recuring
        Route::post('categories/images', 'CategoryController@categoriessaveImages')->name('admin.categories.images.store');
        Route::get('toggleAll/{id}', 'CategoryController@toggleAll')->name('toggle_all');


        
        Route::get('sub-categories/{category}', 'CategoryController@getSubCategories')->name('category.subCategories');
        Route::post('sub-categories/{category}/store', 'CategoryController@subCategoryStore')->name('category.subCategories.store');
        Route::post('sub-categories/{category}/update', 'CategoryController@subCategoryUpdate')->name('category.subCategories.update');
        Route::delete('sub-categories/destroy/{category}','CategoryController@subDestroy')->name('category.subCategories.destroy');
        Route::delete('sub-categories/destroy/all','CategoryController@subDestroyAll')->name('category.subCategories.subDestroyAll');

        // recurring sub categories  module
        Route::get('recurring_categories/index/{id}', 'RecurringSubCategoryController@index')->name('recurring_category.index');
        Route::get('recurring_categories/create/{id}', 'RecurringSubCategoryController@create')->name('recurring_category.create');
        Route::resource('recurring_categories', 'RecurringSubCategoryController');

        // trash in recurring category
        Route::get('trash_recurring_category/{id?}','RecurringSubCategoryController@trash')->name('recurring_category.trash_recurring_category');
        Route::get('restore_recurring_category/{id}','RecurringSubCategoryController@restore')->name('recurring_category.restore_recurring_category');
        Route::post('restore_recurring_category/restore_all','RecurringSubCategoryController@restoreAll')->name('recurring_category.restore_all');
        Route::post('recurring_category/force_delete/{id}','RecurringSubCategoryController@forceDestroy')->name('recurring_category.force_delete');
        Route::post('recurring_category/force_delete_all','RecurringSubCategoryController@forceDestroyAll')->name('recurring_category.force_delete_all');

        Route::get('sub-recurring-categories/{recurring_category}', 'RecurringSubCategoryController@subRecurringIndex')->name('subRecurringCategories.index');
        Route::get('sub-recurring-category/{subRecurringSubCategory}/create', 'RecurringSubCategoryController@subRecurringCreate')->name('subRecurringCategories.create');
        Route::post('sub-recurring-category/{subRecurringSubCategory}/store', 'RecurringSubCategoryController@subRecurringStore')->name('subRecurringCategories.store');
        Route::get('sub-recurring-category/{subRecurringSubCategory}/edit', 'RecurringSubCategoryController@subRecurringEdit')->name('subRecurringCategories.edit');
        Route::post('sub-recurring-category/{subRecurringSubCategory}/update', 'RecurringSubCategoryController@subRecurringUpdate')->name('subRecurringCategories.update');
        Route::delete('sub-recurring-category/{subRecurringSubCategory}/destroy','RecurringSubCategoryController@subRecurringDestroy')->name('subRecurringCategories.destroy');
        Route::delete('recurring-categories/destroy/all','RecurringSubCategoryController@destroyAll')->name('recurringCategories.DestroyAll');
        Route::get('toggleAll_subrecuring/{id}', 'RecurringSubCategoryController@toggleAll_subrecuring')->name('toggle_all_sub_recuring');
        Route::post('sortabledatatable_recurring_category', 'RecurringSubCategoryController@sortable')->name('sortabledatatable_recurring_category');

        // image drop zone for recuring and sub recuring
        // 	Route::post('recurring_sub_categories/images', 'RecurringSubCategoryController@recuringsaveImages')->name('admin.recurring_categories.images.store');
        // 	Route::post('recurring_categories/images', 'RecurringSubCategoryController@subrecuringsaveImages')->name('admin.sub_recurring_categories.images.store');

        Route::post('recurring_sub_categories/images', 'RecurringSubCategoryController@recuringsaveImages')->name('admin.recurring_categories.images.store');
        Route::post('recurring_categories/images', 'RecurringSubCategoryController@recuringsaveImages')->name('admin.sub_recurring_categories.images.store');
    });

});