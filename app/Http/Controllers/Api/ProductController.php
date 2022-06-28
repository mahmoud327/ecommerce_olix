<?php

namespace App\Http\Controllers\Api;

use App\Models\City;
use App\Models\User;
use App\Models\Media;
use App\Models\Feature;
use App\Models\Product;
use App\Jobs\SendOtpSms;
use App\Models\Category;
use App\Models\Property;
use App\Traits\mediaTrait;
use App\Models\Governorate;
use Illuminate\Http\Request;
use App\Jobs\UploadImageToS3;
use App\Models\SubAccountUser;
use App\Models\FilterRecurring;
use App\Models\FeatureSubAccount;
use App\Http\Controllers\Controller;
use App\Models\ProductFavouriteUser;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\ProductCreateResource;
use App\Http\Resources\ProductOfUserResource;
use App\Http\Resources\ProductDetailsResource;

class ProductController extends Controller
{
    use mediaTrait;

    /**
     * @param Request $request
     */
    public function uploadImageInCreate(Request $request)
    {
        $validator = validator()->make($request->all(), [

            "upload_key" => "required",
            "files"      => ["required", "array"],

        ]);

        if ($validator->fails()) {
            return sendJsonError($validator->errors(), '500');
        }

        $images = Media::where('upload_key', $request->upload_key);
        $position = $images->count() ? $images->max('position') : 0;

        $arr_img = [];

        $files = $request->file('files');

        foreach ($files as $file) {
            $file_name = $file->store('uploads/products', 's3');
            Storage::disk('s3')->setVisibility($file_name, 'public');

            array_push($arr_img, $file_name);

            Media::create([

                'url'            => $file_name,
                'full_file'      => $request->getSchemeAndHttpHost() . $file_name,
                'path'           => $file_name,
                'position'       => ++$position,
                'mediaable_type' => 'App\Models\Product',
                'mediaable_id'   => 0,
                'upload_key'     => $request->upload_key,

            ]);
        }

        return sendJsonResponse('Success', 'upload image');
    }

    /**
     * @param Request $request
     */
    public function create(Request $request)
    {
        $lang = $request->header('x-localization');
        $validator = validator()->make($request->all(), [

            'name'        => 'required',
            'price'       => 'required|numeric',
            'city_id'     => 'required|exists:cities,id',
            'category_id' => 'required|exists:categories,id',
            'tap'         => 'required',
            'contact'     => 'required|numeric',

        ]);

        if ($validator->fails()) {
            return sendJsonError($validator->errors(), '500');
            // return sendJsonError('Please make sure that the data entered is correct','409');
        }
        $city = City::where('id', $request->city_id)->first();
        if (!$city) {
            $string = $lang == 'ar' ? "هذا الموقع غير موجود لدينا من فضلك ادخل الموفع من القائمه" : "This site is not available to us. Please enter the file from the list";
            return sendJsonError($string);
        }

        $count = Product::max('position');

        $product = new Product;
        $product->name = ['en' => $request->name, 'ar' => $request->name];
        $product->contact = $request->contact;
        $product->description = $request->description;
        $product->username = $request->username;
        $product->price = $request->price;
        $product->byadmin = 0;

        $product->city_id = (integer) $request->city_id;
        $product->latitude = $request->latitude;
        $product->longitude = $request->longitude;
        $product->status = 'pennding';
        $product->verify_phone = 1;
        $product->link = $request->link;
        $product->discount = $request->discount;
        $product->quantity = $request->quantity;
        $product->contact = $request->contact;
        $product->note = ['en' => $request->note, 'ar' => $request->note];
        $product->category_id = $request->category_id;
        $product->user_id = optional(Auth::guard('api')->user())->id;
        $product->position = $count + 1;

        if (optional(Auth::guard('api')->user())->marketer_code_id) {
            $product->marketer_code_id = optional(Auth::guard('api')->user())->marketer_code_id;
        }

        $user = User::find(optional(Auth::guard('api')->user())->id);

        if ($request->tap == 1) {
            $product->organization_name = "personal";
            $product->organization_id = null;
        } elseif ($request->tap == 2) {
            $product->organization_name = "company";

            if ($user->organization()->exists()) {
                $product->organization_id = $user->organization()->first()->id;
            }
        } else {
            return sendJsonError('dont exists tap value');
        }

        $product->save();

        $sub_account_user_id = SubAccountUser::where('user_id', optional(Auth::guard('api')->user())->id)->pluck('sub_account_id');
        $feature_sub_accounts = FeatureSubAccount::whereIn('sub_account_id', $sub_account_user_id)->pluck('feature_id');
        $product->features()->attach($feature_sub_accounts);

        if ($request->has('sub_filter')) {
            $supFilters = $request['sub_filter'];
            $product->subFilters()->attach($supFilters);
        }

        if ($request->has('upload_key')) {
            $images = Media::where('upload_key', $request->upload_key);
            if ($images->count()) {
                $images->update(['mediaable_id' => $product->id]);
            }
        }

        if (request()->has('images')) {
            $product->update(['images' => $request->images]);
        }

        if ($request->phone) {
            $phone = convert2english(implode(" ", $request->phone));
            $string = 'Approved product Check Current Ads';
            if ($user->mobile != $phone) {
                $is_verified = Product::where('phone', 'LIKE', "%{$phone}%")->where('verify_phone', 1)->where('user_id', $user->id)->count();

                $product->phone = (array) $phone;
                $product->update();

                if (!$is_verified) {
                    $code = rand(1111, 9999);
                    $product->pin_code = $code;
                    $string = "Enter Code to Approve Ads";
                    $product->status = 'disapprove';
                    $product->verify_phone = 0;
                    $product->update();
                }
            }

            $product->phone = (array) $phone;
            $product->update();
        }

        $product->load(['city', 'medias']);

        $string2 = $request->phone ? $string : 'Approved product Check Current Ads';
        if ($product) {
            $product->notifications()->create([

                'title'   => 'products',
                'content' => 'product pennding',
            ]);

            return sendJsonResponse(new ProductCreateResource($product), $string2, 200);
        } else {
            return sendJsonError('500', 'حدث خطأ');
        }
    }

    // to update product
    /**
     * @param Request $request
     * @param $id
     */
    public function update(Request $request, $id)
    {
        $lang = $request->header('x-localization');

        $validator = validator()->make($request->all(), [

            'name'        => 'required',
            'price'       => 'required|numeric',
            "phone"       => "array",
            'contact'     => 'required|numeric',
            'city_id'     => 'required|exists:cities,id',
            'category_id' => 'required|exists:categories,id',

        ]);

        if ($validator->fails()) {
            return sendJsonError($validator->errors()->first(), '500');
        }

        $city = City::where('id', $request->city_id)->first();
        if (!$city) {
            $string = $lang == 'ar' ? "هذا الموقع غير موجود لدينا من فضلك ادخل الموفع من القائمه" : "This site is not available to us. Please enter the file from the list";
            return sendJsonError($string);
        }

        $product = Product::with('medias')->with('organization')->with('features')->find($id);

        if ($product) {
            $user = User::find(Auth::guard('api')->user()->id);

            if ($request->phone) {
                $string = 'Approved product Check Current Ads';

                $phone = implode(" ", $request->phone);

                if ($user->mobile != $phone) {
                    $is_verified = Product::where('phone', 'LIKE', "%{$phone}%")->where('verify_phone', 1)->where('user_id', $user->id)->count();

                    $product->phone = $request->phone;

                    $product->update();

                    if (!$is_verified) {
                        $code = rand(1111, 9999);
                        $product->pin_code = $code;
                        $string = "Enter Code to Approve Ad";

                        $product->status = 'disapprove';
                        $product->verify_phone = 0;
                        $product->update();

                        dispatch(new SendOtpSms("Your code " . $code . " - Suiiz", $phone));
                    }
                }
            }
            $product->username = $request->username;
            $product->note = ['en' => $request->note, 'ar' => $request->note];
            $product->name = ['en' => $request->name, 'ar' => $request->name];
            $product->status = 'pennding';

            $product->update($request->except('note', 'files', 'name'));
            $product->city_id = (integer) $request->city_id;
            $product->phone = $request->phone;
            $product->contact = $request->contact;
            $product->update();

            if ($request->has('images')) {
                $product->media->delete();
                $product->update(['images' => $request->images]);
            }

            $product->subFilters()->sync($request->sub_filter);

            $string2 = $request->phone ? $string : 'Approved product Check Current Ads';

            $product->category_breadcrumbs_path = $product->category->breadcrumbs;

            return sendJsonResponse(new ProductCreateResource($product), $string2, 200);
        } else {
            return sendJsonError('product not found ');
        }
    }

    // to make product finished
    /**
     * @param Request $request
     * @param $id
     */
    public function finished(Request $request, $id)
    {
        $lang = $request->header('x-localization');

        $product = Product::find($id);

        if ($product) {
            $product->status = "finished";
            $product->update();
            $string = $lang == 'ar' ? "تم التحديث إلى منتهي  " : "Updated to Finished";

            return sendJsonResponse('Success', $string);
        } else {
            return sendJsonError('product not found ');
        }
    }

    // to make product approve
    /**
     * @param Request $request
     * @param $id
     */
    public function repenndingProduct(Request $request, $id)
    {
        $product = Product::find($id);
        $lang = $request->header('x-localization');

        if ($product) {
            if ($product->verify_phone) {
                $product->status = 'pennding';
                $product->verify_phone = 1;
                $product->update();

                $string = $lang == 'ar' ? "تم موافقة المنتج" : "approve";

                return sendJsonResponse(new ProductCreateResource($product), $string, 200);
            } else {
                $code = rand(1111, 9999);
                $product->pin_code = $code;
                $product->verify_phone = 0;
                $product->update();

                dispatch(new SendOtpSms("Your code " . $code . " - Suiiz", (string) $product->phone[0]));
                return sendJsonResponse(new ProductCreateResource($product), 'the product is suspending now, please verfiy your code to approve it', 200);
            }
        } else {
            return sendJsonError('product not found ');
        }
    }

    // to get products of user
    /**
     * @param Request $request
     */
    public function getProductsOfUser(Request $request)
    {
        $products = Product::orderBy('promote_to', 'desc')
            ->orderBy('position', 'DESC')
            ->with('medias')
            ->with('organization')
            ->with('features')
            ->where('user_id', Auth::guard('api')->user()->id)
            ->where(function ($q) use ($request) {
                if ($request->has('keyword')) {
                    $q->where('status', $request->keyword);
                }
            })->paginate(10);

        return response()->json(new ProductOfUserResource($products));
    }

    /**
     * @param $id
     */
    public function destroy($id)
    {
        $product = Product::find($id);

        if ($product) {
            $product->medias()->forceDelete();

            $product->subFilters()->detach();
            $product->delete();

            return sendJsonResponse('deleted', 'deleted successfully.');
        } else {
            return sendJsonError('dont found product');
        }
    }

    /**
     * @param Request $request
     */
    public function addfavourite(Request $request)
    {
        $lang = $request->header('x-localization');
        $validator = validator()->make($request->all(), [

            'product_id' => 'required|exists:products,id|numeric',

        ]);

        if ($validator->fails()) {
            return sendJsonError($validator->errors()->first(), '409');
        }

        $product = Product::where('id', $request->product_id)->first();

        if (!ProductFavouriteUser::where('user_id', Auth::guard('api')->user()->id)->where('product_id', $request->product_id)->count()) {
            $favourite = new ProductFavouriteUser;
            $favourite->user_id = Auth::guard('api')->user()->id;
            $favourite->product_id = $request->product_id;
            $favourite->status = 1;
            $favourite->save();
        } else {
            ProductFavouriteUser::where('user_id', Auth::guard('api')->user()->id)->where('product_id', $request->product_id)->update(['status' => 1]);
        }
        $string = $lang == 'ar' ? "تم اضافة المنتج الى المنتجات المفضله" : "add favourite";

        return sendJsonResponse('Success', $string);
    }

    /**
     * @param Request $request
     */
    public function deletefavourite(Request $request)
    {
        $lang = $request->header('x-localization');

        $validator = validator()->make($request->all(), [

            'product_id' => 'required|exists:products,id|numeric',

        ]);

        if ($validator->fails()) {
            return sendJsonError($validator->errors()->first(), '409');
        }

        $product = Product::where('id', $request->product_id)->first();

        $favourite = ProductFavouriteUser::where('user_id', Auth::guard('api')->user()->id)->where('product_id', $request->product_id)->first();
        if ($favourite) {
            $favourite->status = 0;
            $favourite->save();
            $string = $lang == 'ar' ? "تم حذف المنتج من المنتجات المفضله " : "delete favourite";

            return sendJsonResponse('Success', 'delete favourite');
        } else {
            return sendJsonError('you didn\'t make favourite in this product');
        }
    }

    /**
     * @param Request $request
     */
    public function allfavourite(Request $request)
    {
        $products = Product::query()
            ->where('status', 'approve')
            ->orderBy('promote_to', 'desc')
            ->orderBy('position', 'DESC')
            ->whereHas('favourites', function ($q) use ($request) {
                $q->where('user_id', Auth::guard('api')->user()->id)->where('status', 1);
            })
            ->with(['medias', 'organization'])
            ->paginate(10);

        if ($products->count()) {
            return response()->json(new ProductResource($products));
        } else {
            return sendJsonError('dont found product favourite');
        }
    }

    /**
     * @param $product_id
     */
    public function show(Product $product)
    {
        $product->load(['user', 'organization', 'category.filterRecurrings', 'subFilters', 'subProperties']);

        $userProduct = Auth::guard('api')->check()
        ? ProductFavouriteUser::where('product_id', $product->id)->where('user_id', Auth::guard('api')->user()->id)->first()
        : '';

        $product->is_favorited = $userProduct ? ($userProduct->status == '0' ? 'false' : 'true') : 'false';

        $product->username = $product->username ?? $product->user_id
        ? ($product->organization_id ? optional($product->organization)->name : optional($product->user)->name)
        : 'suiiz';

        $product->user_image = $product->user_image ?? $product->user_id
        ? ($product->organization_id
            ? config('filesystems.disks.s3.url') . '/' . (optional($product->organization)->media ? optional($product->organization->media)->path : 'uploads/avatar.png')
            : config('filesystems.disks.s3.url') . '/' . $product->user->image)
        : 'suiiz';

        $product->discount = $product->discount ? $product->price * $product->discount / 100 : 0;
        $product->priceAfterdiscount = $product->discount ? $product->price - $product->discount : null;

        $product->cairo = Governorate::where('name', 'LIKE', '%Cairo%')->first();

        $subFiltersIds = $product->subFilters->sortBy('position')->pluck('pivot.sub_filter_recurring_id');

        $product->filters = FilterRecurring::orderby('position', 'asc')
            ->whereHas('categories', function ($q) use ($product) {
                $q->where('category_filter_recurring.category_id', $product->category_id);
            })
            ->with(array('subFiltersRecurring' => function ($q) use ($subFiltersIds) {
                $q->whereIn('id', $subFiltersIds)->orderby('position');
            }))
            ->get();

        $subPropertiesId = $product->subProperties->pluck('sub_property_id');
        $propertiesId = $product->subProperties->pluck('property_id');
        $product->properties = Property::whereIn('id', $propertiesId)
            ->with(['subProperties' => function ($q) use ($subPropertiesId, $product) {
                $q->whereIn('id', $subPropertiesId)->with(['products' => function ($q) use ($product) {
                    $q->where('product_id', $product->id);
                }]);
            }])
            ->get();

        $product->features = Feature::get();

        return sendJsonResponse(ProductDetailsResource::make($product), 'product');
    }

    /**
     * @param Request $request
     */
    public function productserach(Request $request)
    {
        $products = Product::where('status', "approve")->orderBy('promote_to', 'desc')->orderBy('position', 'DESC');

        if ($request->has('category_id')) {
            $products->where(function ($q) use ($request) {
                $arr = array();
                $last_categories_ids = lastCategoriesIds($request->category_id, $arr);
                $products = $q->whereIn('category_id', $last_categories_ids);
            });
        }

        if ($request->has('name')) {
            $products->where(function ($q) use ($request) {
                $products = $q->whereRaw('(name like "%' . strtolower($request->name) . '%" or name->"$.ar" like "%' . strtolower($request->name) . '%")');
            });
        }

        if ($request->has('phone')) {
            $products->where(function ($q) use ($request) {
                $products = $q->where('phone', 'LIKE', '%' . $request->phone . '%');
            });
        }

        if ($request->has('description')) {
            $products->where(function ($q) use ($request) {
                $products = $q->where('description', 'LIKE', '%' . $request->description . '%');
            });
        }
        if ($request->has('note')) {
            $products->where(function ($q) use ($request) {
                $products = $q->where('note', 'LIKE', '%' . $request->note . '%');
            });
        }

        if ($request->has('price')) {
            $products->where(function ($q) use ($request) {
                $products = $q->where('price', 'LIKE', '%' . $request->price . '%');
            });
        }

        if ($request->has('city_id')) {
            $products->where(function ($q) use ($request) {
                $products = $q->where('city_id', $request->city_id);
            });
        }

        if ($request->has('governorate_id')) {
            $citie_ids = City::where('governorate_id', $request->governorate_id)->pluck('id');
            $products->where(function ($q) use ($citie_ids) {
                $products = $q->whereIn('city_id', $citie_ids);
            });
        }

        $products = $products->where('status', "approve")->with(['medias', 'organization'])->paginate(10);

        return response()->json(new ProductResource($products));

        // return $products;
        // return sendJsonResponse(ProductResource::collection($products),'products');
    }

    /**
     * @param $cat_id
     * @param $sort
     */
    public function ProductsOfCategory($cat_id, $sort = null)
    {
        $category = Category::find($cat_id);
        if ($category) {
            $arr = array();
            $last_categories_ids = lastCategoriesIds($cat_id, $arr);

            // return $last_categories_ids;
            $products = Product::query()
                ->where('status', '=', 'approve')
                ->orderBy('promote_to', 'desc')
                ->orderBy('position', 'DESC')
                ->whereIn('category_id', $last_categories_ids)
                ->with(['organization', 'medias'])
                ->paginate(10);

            if ($sort != null) {
                $products = Product::query()
                    ->where('status', 'approve')
                    ->whereIn('category_id', $last_categories_ids)
                    ->with(['medias', 'organization'])
                    ->orderby('price', $sort)
                    ->paginate(10);
                return response()->json(new ProductResource($products));
            }

            return response()->json(new ProductResource($products));
        } else {
            return sendJsonError('category not found');
        }
    }

    /**
     * @param Request $request
     * @param $id
     */
    public function deleteimage(Request $request, $id)
    {
        $lang = $request->header('x-localization');
        $media = Media::Find($id);

        if ($media) {
            Storage::disk('s3')->delete($media->path);
            $media->forceDelete();

            $string = $lang == 'ar' ? "تم حذف الصوره" : "image has been deleted successfully ";
            return sendJsonResponse('Success', $string);
        }

        return sendJsonError('dont found image');
    }

    /**
     * @param Request $request
     */
    public function uploadImageToS3(Request $request)
    {
        $lang = $request->header('x-localization');
        $validator = validator()->make($request->all(), [

            'product_id' => 'required|integer',
            "files"      => ["required", "array"],
        ]);

        if ($validator->fails()) {
            return sendJsonError($validator->errors(), '500');
        }

        $product = Product::find($request->product_id);

        if ($product) {
            $arr_img = [];

            $position = $product->medias()->max('position');
            $position = $position ? $position : $position = 0;
            $files = $request->file('files');
            foreach ($files as $file) {
                $file_name = $file->store('uploads/products', 's3');
                Storage::disk('s3')->setVisibility($file_name, 'public');

                array_push($arr_img, $file_name);

                $product->medias()->create([

                    'url'       => $file_name,
                    'full_file' => $request->getSchemeAndHttpHost() . $file_name,
                    'path'      => $file_name,
                    'position'  => ++$position,

                ]);
            }
            $string = $lang == 'ar' ? "تم رفع الصوره" : "upload image";

            return sendJsonResponse('Success', $string);
        } else {
            return sendJsonError('dont found product');
        }
    }

    /**
     * @param Request $request
     */
    public function mainimage(Request $request)
    {
        $lang = $request->header('x-localization');

        $validator = validator()->make($request->all(), [

            'product_id' => 'required|integer',
            'image_id'   => 'required|integer',

        ]);

        if ($validator->fails()) {
            return sendJsonError($validator->errors(), '500');
        }

        $product = Product::find($request->product_id);

        $media_first = Media::where('mediaable_id', $request->product_id)->first();

        $old_url = $media_first->url;
        $old_full_file = $media_first->full_file;
        $old_path = $media_first->path;

        $media = Media::where('mediaable_id', $request->product_id)->where('id', $request->image_id)->first();

        if ($media_first) {
            if ($product) {
                $media_first->update([

                    'url'       => $media->url,
                    'full_file' => $media->full_file,
                    'path'      => $media->path,
                ]);

                $media->update([

                    'url'       => $old_url,
                    'full_file' => $old_full_file,
                    'path'      => $old_path,
                ]);
                $string = $lang == 'ar' ? "تم رفع الصوره" : "upload image";

                return sendJsonResponse($product->medias, $string);
            } else {
                return sendJsonError('dont found product');
            }
        } else {
            return sendJsonError('dont found media');
        }
    }

    /**
     * @param Request $request
     */
    public function search(Request $request)
    {
        $products = Product::where('status', "approve")->with(['city', 'city.governorate', 'user', 'category', 'category.parents', 'subProperties']);

        if ($request->has('sort')) {
            $products = $products->orderBy('price', $request->sort);
        } else {
            $products = $products->orderBy('promote_to', 'desc')->orderBy('position', 'DESC');
        }
        if ($request->has('name')) {
            $products->where(function ($q) use ($request) {

                // $products = $q->whereRaw('(name like "%' . strtolower($request->name) . '%" or name->"$.ar" like "%' . $request->name . '%")');

                $products = $q->where('name', 'like', "%" . strtolower($request->name) . "%")->orwhere('name', 'like', "%" . $request->name . "%");
            });
        }

        if ($request->has('category_id')) {
            $arr = array();
            $last_categories_ids = lastCategoriesIds($request->category_id, $arr);

            $products->where(function ($q) use ($last_categories_ids) {
                $q->whereIn('category_id', $last_categories_ids);
            });
        }

        if ($request->has('description')) {
            $products->where(function ($q) use ($request) {
                $products = $q->where('description', 'LIKE', '%' . $request->description . '%');
            });
        }

        if ($request->has('city_id')) {
            $products->where(function ($q) use ($request) {
                $products = $q->where('city_id', $request->city_id);
            });
        }

        if ($request->has('governorate_id')) {
            $citie_ids = City::where('governorate_id', $request->governorate_id)->pluck('id');
            $products->where(function ($q) use ($citie_ids) {
                $products = $q->whereIn('city_id', $citie_ids);
            });
        }

        if ($request->has('price_from') && $request->has('price_to')) {
            $products->where(function ($q) use ($request) {
                $products = $q->whereBetween('price', [$request->price_from, $request->price_to]);
            });
        }

        if ($request->has('sup_flters_id')) {
            foreach ($request->sup_flters_id as $parent => $filter) {
                $products = $products->whereHas('subFilters', function ($q) use ($request, $filter, $parent) {
                    $filter = json_decode($filter);

                    $q->where(function ($q) use ($filter, $parent) {
                        $key = key((array) $filter);

                        $array = (array) $filter->$key;
                        $q->whereIn('product_sub_filter_recurring.sub_filter_recurring_id', $array);
                    });
                });
            }
        }
        // return $products;

        // return $products = $products->toSql();

        //

        $products = $products->paginate(10);

        return response()->json(new ProductResource($products));
    }

    /**
     * @param Request $request
     */
    public function countOfFilteredProducts(Request $request)
    {
        $products = Product::where('status', "approve");

        if ($request->has('name')) {
            // return json_decode($request->name);
            $products->where(function ($q) use ($request) {

                // $products = $q->whereRaw('(name like "%' . strtolower($request->name) . '%" or name->"$.ar" like "%' . strtolower($request->name) . '%")');
                $products = $q->where('name', 'like', "%" . strtolower($request->name) . "%")->orwhere('name', 'like', "%" . $request->name . "%");
            });
        }

        if ($request->has('description')) {
            $products->where(function ($q) use ($request) {
                $products = $q->where('description', 'LIKE', '%' . $request->description . '%');
            });
        }

        if ($request->has('city_id')) {
            $products->where(function ($q) use ($request) {
                $products = $q->where('city_id', $request->city_id);
            });
        }

        if ($request->has('governorate_id')) {
            $citie_ids = City::where('governorate_id', $request->governorate_id)->pluck('id');
            $products->where(function ($q) use ($citie_ids) {
                $products = $q->whereIn('city_id', $citie_ids);
            });
        }

        if ($request->has('price_from') && $request->has('price_to')) {
            $products->where(function ($q) use ($request) {
                $products = $q->whereBetween('price', [$request->price_from, $request->price_to]);
            });
        }

        if ($request->has('sup_flters_id')) {
            foreach ($request->sup_flters_id as $parent => $filter) {
                $products = $products->whereHas('subFilters', function ($q) use ($request, $filter, $parent) {
                    $filter = json_decode($filter);

                    $q->where(function ($q) use ($filter, $parent) {
                        $key = key((array) $filter);

                        $array = (array) $filter->$key;
                        $q->whereIn('product_sub_filter_recurring.sub_filter_recurring_id', $array);
                    });
                });
            }
        }

        if ($request->has('category_id')) {
            $arr = array();
            $last_categories_ids = lastCategoriesIds($request->category_id, $arr);
            $products->where(function ($q) use ($last_categories_ids) {
                $products = $q->whereIn('category_id', $last_categories_ids);
            });
        }

        $count = $products->count();

        return sendJsonResponse(['count' => $count], 'Count Of Products', 200);
    }

    // to increment the chat counter
    /**
     * @param Request $request
     * @param $id
     */
    public function increment(Request $request, $id)
    {
        $product = Product::find($id);
        if ($product) {
            if ($request->has('keyword')) {
                if ($product->user_id != auth()->guard('api')->user()->id) {
                    if ($request->keyword == 'chat') {
                        $product->count_chat = $product->count_chat + 1;
                        $product->update();
                        return sendJsonResponse('Update Successfully.', 200);
                    } elseif ($request->keyword == 'phone') {
                        $product->count_phone = $product->count_phone + 1;
                        $product->update();
                        return sendJsonResponse('Update Successfully.', 200);
                    } elseif ($request->keyword == 'view') {
                        $product->count_view = $product->count_view + 1;
                        $product->update();
                        return sendJsonResponse('Update Successfully.', 200);
                    } else {
                        return sendJsonError('the keyword must be just chat or phone or view');
                    }
                }

                return sendJsonResponse('Update Successfully.', 200);
            } else {
                return sendJsonError('you have to enter the keyword');
            }
        } else {
            return sendJsonError('product dose not exist');
        }
    }

    /**
     * @param Request $request
     */
    public function verifyCodeAddProduct(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'pin_code'   => 'required|exists:products,pin_code',
            'product_id' => 'required|exists:products,id',

        ]);

        if ($validator->fails()) {
            return sendJsonError($validator->errors()->first(), 200);
        }

        $product = Product::where('pin_code', $request->pin_code)->where('pin_code', '!=', 0)->where('id', $request->product_id)->first();
        $user = User::find(Auth::guard('api')->user()->id);

        if ($product) {
            $product->verify_phone = 1;
            $product->pin_code = null;
            $product->status = 'pennding';
            if ($product->update()) {
                $phone = $product->phone[0];
                Product::where('phone', 'LIKE', "%{$phone}%")->where('user_id', $user->id)->update(['verify_phone' => 1]);
            }

            return sendJsonResponse($product, 'Approved product Check Current Ads', 200);
        } else {
            return sendJsonError('Code is invaild Check Suspended Ads ');
        }
    }

    public function penddingProduct()
    {
        if (Auth::guard('api')->check()) {
            $product_user = Product::where('user_id', Auth::user()->id)->where('status', 'pennding')->get();

            return sendJsonResponse(ProductOfUserResource::collection($product_user), 'Products of user');
        }
    }

    // to resend new code
    /**
     * @param Request $request
     */
    public function reSendCode(Request $request)
    {
        $validator = validator()->make($request->all(), [

            'product_id' => 'required|exists:products,id',

        ]);

        if ($validator->fails()) {
            return sendJsonError($validator->errors()->first(), 200);
        }

        $product = Product::where('id', $request->product_id)->first();

        $code = rand(1111, 9999);
        $product->update(['pin_code' => $code]);
        dispatch(new SendOtpSms("Your code " . $code . " - Suiiz", (string) $product->phone[0]));
        return sendJsonResponse('Success', 'the new code has been sent successfully.');
    }
}
