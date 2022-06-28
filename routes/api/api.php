<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['prefix' => 'v1', 'namespace'=>'Api'],function ()
{


        // Route::get('admin/about_us','AboutUsController@getAboutUs');

        Route::get('admin/terms',function(){

            return response()->view('web.admin.about_us.about_us');
        });

        Route::get('/setting','SettingController@setting');
        Route::get('/get-accounts','AccountController@getAccount');
        Route::get('/category_advertisment/{category_id}','AdvertismentController@getAdvertisment');


        // address services
        Route::get('all_governorates','GovernorateController@allGovernorates');
        Route::post('search_in_cities','CityController@searchInCities');


        // compalin and contact services
        Route::post('complain','ComplainmentController@complain');
        Route::post('contact','ContactController@contact');

        ////organization_service
        Route::post('/organization_service','OrganizationServiceController@getOrganizationService');

        // change language service
        Route::post('/change-language','ChangeLanguageController@change_language');


        // categories services
        Route::get('all_categories','CategoryController@allCategories');
        Route::get('parent_categories/{tab?}','CategoryController@ParentCategories');
        Route::get('sub_categories/{cat_id?}/{tab?}','CategoryController@SubCategories');


        // filters services
        Route::get('/filter/{cat_id}/{tap}','FillterController@getFilters');

        // features services
        Route::get('/features','FeturesController@getFeatures');

        // notification services
        Route::get('/get_notifications','NotificationController@getNotifications');
        Route::post('/send_notification_in_chat','NotificationController@sendNotificationInChat');


        Route::group(['middleware' => 'auth:api'],function ()
        {

            // use points services
            Route::post('promote_product','UsePointsController@promoteProduct');
            Route::post('renewal_product','UsePointsController@productRenewal');

            ///product_reports
            Route::post('product_reports','ProductReportController@product_reports');

            // save search services
            Route::get('all_saved_search','SaveSearchController@allSavedSearch');
            Route::Post('save_search','SaveSearchController@saveSearch');
            Route::Post('delete_search','SaveSearchController@deleteSaveSearch');

            Route::post('/service_request','ServiceRequestController@serviceRequestStore');
        });


});

