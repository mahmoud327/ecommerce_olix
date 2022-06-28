<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1', 'namespace' => 'Api'], function () {
    Route::group(['prefix' => 'product'], function () {
        Route::post('verify_code', 'ProductController@verifyCodeAddProduct');
        Route::post('resend_product_verify_code', 'ProductController@reSendCode');
        // Route::get('productdetails/{product}', 'ProductController@show');

        Route::post('search_product', 'ProductController@productserach');
        Route::get('/{cat_id}/{sort?}', 'ProductController@ProductsOfCategory');
        // Route::post('serach-with-filter', 'ProductController@search');
        Route::post('count_of_filtered_products', 'ProductController@countOfFilteredProducts');

        Route::group(['middleware' => 'auth:api'], function () {
            // Route::post('upload_product_images', 'ProductController@uploadImageInCreate');
            // Route::post('create', 'ProductController@create');
            // Route::post('update/{id}', 'ProductController@update');
            Route::Post('addfavourite', 'ProductController@addfavourite');
            Route::get('pendding_product', 'ProductController@penddingProduct');
            Route::Post('deletefavourite', 'ProductController@deletefavourite');
            Route::post('allfavourite', 'ProductController@allfavourite');
            // Route::delete('delete/{id}', 'ProductController@destroy');
            Route::post('products_of_user', 'ProductController@getProductsOfUser');
            Route::post('finished/{product_id}', 'ProductController@finished');
            Route::post('approve/{product_id}', 'ProductController@repenndingProduct');
            Route::post('/increment/{id}', 'ProductController@increment');

        });

    });

});
