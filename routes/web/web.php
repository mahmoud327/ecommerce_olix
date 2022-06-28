<?php

use Illuminate\Support\Facades\Route;
use App\Models\Category;
use App\Models\Product;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('qr',function(){
	return view('qr.show');
});

Route::get('app',function(){
	return view('qr.redirect');
})->name('redirect.to.appstore');

Route::get('admin/about_us',function(){
	return view('web.admin.about_us.about_us');
});

Route::get('admin/terms',function(){
	return view('web.admin.terms.terms_en');
});
Auth::routes();

Route::group(['prefix' => LaravelLocalization::setLocale(),
    'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ] ], function()
{

	Route::get('/', function () {
		return view('index');

	})->name('admin.index')->middleware('auth:admins');

// 	Route::get('/download_imagess', function () {

//  // 43604

// 		$images = App\Models\Media::onlyTrashed()->where('mediaable_type', 'App\Models\Product')->orderby('id', 'desc')->count();
// 		return $images;
// 		$images = App\Models\Media::where('mediaable_type', 'App\Models\Product')->whereBetween('id', [41000, 42000])->get();

// 		foreach($images as $image)
// 		{

// 			$new_path = str_replace('products', 'products2/products', $image->path);
// 			$file_name = explode('/', $new_path);

// 			// return $file_name[3];
// 			if ( Storage::disk('s3')->exists($new_path) )
// 			{

// 				$image = Storage::disk('s3')->get($new_path);

// 				if( ! Storage::disk('products')->exists($file_name[3]))
// 				{

// 					$s3 = Storage::disk('products');
// 					$s3 ->put(  $file_name[3],  $image);
// 				}

// 			}

// 		}

// 		dd( 'aaaaaaaaa' );

// 	});



	Route::get('/bbb', function () {

		// 43604


			//    $users_phones = App\Models\User::whereDate('created_at', '>=', date('2021-10-23').' 00:00:00')->get();
			//    return $users_phones;
			//    $products = App\Models\Product::where('marketer_code_id', 'SA#ggvU')->get();
			//    $products = App\Models\Product::whereDate('created_at', '>=', date('2021-10-23').' 00:00:00')->get();
				// return $products;
			//    	foreach( $products as $product)
			// 	{
			// 		// return $product;
			// 		if($product->phone)
			// 		{

			// 			$phone = $product->phone[0];

			// 			// return $phone;

			// 			$user = App\Models\User::where('mobile', 'LIKE' ,  $phone  )->first();

			// 			// return $user;

			// 			if($user)
			// 			{
			// 				// return $user->id;
			// 				$product->update(['user_id' => $user->id, 'marketer_code_id' => $user->marketer_code_id]);
			// 				// return $product;
			// 			}

			// 		}

			// 	}

			//    dd('aaaaaaaaa');

		// \App\Models\Product::whereDate('promote_to', '>', \Carbon\Carbon::today());


	});



	Route::get('admin/about_us',function(){

		return response()->view('web.admin.about_us.about_us');
	});
	Route::get('admin/notification', 'Web\Admin\NotificationController@notification');
	Route::group(['prefix' => 'admin','middleware' => 'auth:admins' , 'namespace' =>'Web\Admin'], function () {

		// Route::get('notification', 'NotificationController@notification');
		Route::resource('contacts','ContactController');
		Route::delete('contacts/destroy/all','ContactController@delete_all')->name('contacts.delete_all');

		Route::get('prodouct_reports/{product_id}','ProductReportController@index')->name('product.prodouct_reports');
		Route::delete('prodouct_reports/destroy/all','ProductReportController@delete_all')->name('prodouct_reports.delete_all');

		Route::resource('complainments','ComplainmentController');
		Route::delete('complainments/destroy/all','ComplainmentController@delete_all')->name('complainments.delete_all');

		// Views module
		Route::resource('views', 'ViewController');
		Route::delete('views/destroy/all','ViewController@delete_all')->name('views.delete_all');


		//features  module
		Route::resource('features', 'FeatureController');
		Route::delete('feature/delete_all', 'FeatureController@delete_all')->name('feature.delete_all');



		//setting module
		Route::resource('settings', 'SettingController');

		// store and delete
		Route::get('delete/setting_image', 'SettingController@delete_file');
		Route::post('images_setting', 'SettingController@saveSettingImages')->name('admin.settings.images.store');



		Route::resource('governorates', 'GovernorateController');

		// city module
		Route::resource('cities', 'CityController');
		Route::get('/organization_service_cities', 'CityController@city')->name('organization_service_cities');

		Route::get('product_review/{id}', 'ProductController@productReview')->name('product_review');

	});



	Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

});
