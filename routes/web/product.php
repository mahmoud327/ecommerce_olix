<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath'], 'namespace' => 'Web\Admin'], function () {

    Route::group(['prefix' => 'admin', 'middleware' => 'auth:admins'], function () {
        // product
        Route::resource('products', 'ProductController');
        Route::get('pendding_mobile', 'ProductController@ajaxPenddingMobile');
        ///pagination ajax
        Route::get('productsofcatrgory/pagination/fetch_data', 'ProductController@fetch_data');
        Route::get('productsofdashboard/pagination/fetch_data', 'ProductController@fetch_dataDashboard');
        Route::get('search/result_search/pagination/fetch_data', 'ProductController@PaginateResultSearch');

        Route::delete('products/destroy/all', 'ProductController@delete_all')->name('products.delete_all');
        Route::post('products/available/all', 'ProductController@available_all')->name('products.available_all');
        Route::post('products/finish/all', 'ProductController@finish_all')->name('products.finish_all');
        Route::post('products/disapprove/all', 'ProductController@disapprove_all')->name('products.disapprove_all');

        // approve or disapprove for product
        Route::post('products/search', 'ProductController@searchs')->name('products.serach');
        Route::get('product/approve{id}', 'ProductController@approve')->name('product.approve');
        Route::post('product/disapprove{id}', 'ProductController@disapprove')->name('product.disapprove');
        Route::get('product/finished{id}', 'ProductController@finished')->name('product.finished');

        // store and delete
        Route::get('product/delete/image', 'ProductController@delete_file');
        Route::post('images', 'ProductController@saveProductImages')->name('admin.products.images.store');
        //sort images of category
        Route::post('sort_product_images', 'ProductController@sortImages')->name('sort_product_images');
        // delete image of product
        Route::post('delete_product_image', 'ProductController@deleteImage')->name('delete_product_image');

        //module productofcategory
        Route::get('productsofcatrgory/{id}', 'ProductController@productsofcategoryindex')->name('product.productsofcategoryindex');
        Route::get('productsofcatrgory/create/{id}', 'ProductController@productofcatrgorycreate')->name('product.productofcatrgorycreate');
        Route::get('productsofcatrgory/edit/{id}', 'ProductController@productofcatrgoryedit')->name('product.productofcatrgoryedit');
        Route::post('productsofcatrgory/update/{id}', 'ProductController@productofcatrgoryupdate')->name('product.productofcatrgoryupdate');
        Route::post('productsofcatrgory/store/{id}', 'ProductController@productofcatrgorystore')->name('product.productofcatrgorystore');
        // Route::post('productsofcatrgory/search/{id}', 'ProductController@searchproductofcategory')->name('productsofcatrgory.serach');

        // trash in product
        Route::get('trash_products_of_catrgory/{cat_id}', 'ProductController@trashOfCategory')->name('product.trash_products_of_catrgory');
        Route::get('trash_products_of_finish', 'ProductController@trashFinshProduct')->name('product.trash_products_of_finish');
        Route::get('trash_products_of_pennding', 'ProductController@trashPenndingProduct')->name('product.trash_products_of_pennding');
        Route::get('trash_products_of_disapprove', 'ProductController@trashDisapproveProduct')->name('products.trash_products_of_disapprove');
        Route::get('trash_products_of_approve', 'ProductController@trashApproveProduct')->name('products.trash_products_of_approve');
        Route::get('trash_products_of_finishMobile', 'ProductController@trashFinishMobileProduct')->name('products.trash_products_of_finishMobile');
        Route::get('restore_product/{id}', 'ProductController@restore')->name('product.restore_product');
        Route::post('restore_product/restore_all', 'ProductController@restoreAll')->name('product.restore_all');
        Route::post('product/force_delete/{id}', 'ProductController@forceDestroy')->name('product.force_delete');
        Route::post('product/force_delete_all', 'ProductController@forceDestroyAll')->name('product.force_delete_all');

        // module productofdashboard
        Route::get('productsofdashboard', 'ProductController@productofdashboardindex')->name('products.productofdashboardindex');
        Route::get('productsofdashboardfinish', 'ProductController@productofdashboardfinish')->name('products.productofdashboardfinsih');
        Route::get('producstofdashboarddeleted', 'ProductController@producstofdashboarddeleted')->name('products.productofdashboarddeleted');

        // module productofmobile
        Route::get('productsofmobile', 'ProductController@productofmobileindex')->name('products.productofmobileindex');
        Route::get('productsofmobile_finish', 'ProductController@productMobileFinish')->name('products.productsofmobile_finish');
        Route::get('productsofmobile_aprove', 'ProductController@productMobileApprove')->name('products.productsofmobile_aprove');
        Route::get('productsofmobile_disaprove', 'ProductController@productMobileDisapprove')->name('products.productsofmobile_disaprove');
        Route::get('productsofmobile_pennding', 'ProductController@productMobilePennding')->name('products.productsofmobile_pennding');
        Route::get('producstofmobiledeleted', 'ProductController@producstofmobiledeleted')->name('products.productofmobiledeleted');
        Route::post('product_sortabledatatable', 'ProductController@sortable')->name('product_sortabledatatable');
        Route::get('/search/product_dashboard', 'ProductController@search')->name('product_dashboard.search');
        Route::get('/search/productOfCategory', 'ProductController@productOfCategorySearch')->name('productOfCategory.search');

        Route::get('productsofmobile_aprove/pagination/fetch_data', 'ProductController@approveMobilePaginate');
        Route::get('/search/product_mobile_approve', 'ProductController@searchProductMobileApprove')->name('product_mobile_approve.search');
        Route::get('/search/productsofmobile_aprove/pagination/fetch_data', 'ProductController@approveMobilePaginateResult');

    });

});
