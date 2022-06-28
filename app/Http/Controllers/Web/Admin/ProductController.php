<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Admin\ProductRequest;
use App\Models\Category;
use App\Models\FilterRecurring;
use App\Models\Media;
use App\Models\MediaCenter;
use App\Models\Product;
use App\Models\ProductSubProperty;
use App\Models\User;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('permission:products_of_category', ['only' => ['product.productsofcategoryindex']]);
        $this->middleware('permission:create_product_of_category', ['only' => ['product.productofcatrgorycreate', 'product.productofcatrgorystore']]);
        $this->middleware('permission:update_product_of_category', ['only' => ['product.productofcatrgoryupdate', 'product.productofcatrgoryedit']]);
        $this->middleware('permission:delete_product_of_category', ['only' => ['destroy']]);
    }
    public function index()
    {
        $products = Product::paginate(200);
        return view('web.admin.products.index', compact('products'));

    }

    /**
     * @param $id
     */
    public function destroy($id)
    {

        $product = Product::find($id);
        $product->delete();

        return back()->with('status', "Deleted successfully");

    }

    /**
     * @param Request $request
     */
    public function delete_all(Request $request)
    {

        if ($request->delete_all_id) {

            $delete_all_id = explode(",", $request->delete_all_id);
            if (in_array('on', $delete_all_id)) {

                array_shift($delete_all_id);
            }
            Product::whereIn('id', $delete_all_id)->delete();
        }
        return back()->with('status', "Deleted successfully");

    }

    /**
     * @param Request $request
     */
    public function available_all(Request $request)
    {

        if ($request->available_all_id) {
            $available_all_id = explode(",", $request->available_all_id);
            if (in_array('on', $available_all_id)) {

                array_shift($available_all_id);
            }
            Product::whereIn('id', $available_all_id)->update(['status' => 'approve']);
        }
        return back()->with('status', "Deleted successfully");

    }

    /**
     * @param Request $request
     */
    public function disapprove_all(Request $request)
    {

        if ($request->disapprove_all_id) {

            $disapprove_all_id = explode(",", $request->disapprove_all_id);

            if (in_array('on', $disapprove_all_id)) {

                array_shift($disapprove_all_id);
            }

            Product::whereIn('id', $disapprove_all_id)->update(['status' => 'disapprove']);
        }
        return back()->with('status', "Deleted successfully");

    }

    /**
     * @param Request $request
     */
    public function finish_all(Request $request)
    {

        if ($request->finish_all_id) {

            $finish_all_id = explode(",", $request->finish_all_id);

            if (in_array('on', $finish_all_id)) {

                array_shift($finish_all_id);
            }
            Product::whereIn('id', $finish_all_id)->update(['status' => 'finished']);
        }
        return back()->with('status', "Deleted successfully");

    }

    // save product images
    /**
     * @param Request $request
     */
    public function saveProductImages(Request $request)
    {
        $file = $request->file('dzfile');
        $filename = uploadProductImage('uploads/products/', $file);

        return response()->json([
            'name' => $filename,
            'original_name' => $file->getClientOriginalName(),
        ]);
    }
    ////////////////delete image from database in edit dropzone
    /**
     * @param Request $request
     */
    public function delete_file(Request $request)
    {
        $media = Media::where('id', $request->id)->first();

        if ($media) {

            \Storage::disk('s3')->delete($media->path);
            $media->forceDelete();

        } else {

            \Storage::disk('s3')->delete($media->path);

        }

        return 'sucess';

    } /////////approve post//////////////////////////////////

    /**
     * @param Request $request
     * @param $id
     */
    public function disapprove(Request $request, $id)
    {
        $product = Product::find($id);

        if ($product) {
            $product->status = "disapprove";
            $product->rejected_reason = $request->rejected_reason;

            if ($product->update()) {

                if ($product->user()->exists()) {

                    $lang = $product->user->lang;

                    if ($lang == 'en') {

                        $title = 'Suiiz Support';
                        $body = 'Your ad has been rejected because ' . $request->rejected_reason . ' , edit your ad and try again';

                    } else {

                        $title = 'Suiiz الدعم الفني لدي';
                        $body = ', تم رفض اعلانك والسبب' . $request->rejected_reason . 'قم بتعديل الاعلان ثم حاول مره اخري.';
                    }

                    if ($product->save()) {
                        $tokens = $product->user()->where('fcm_token', '!=', null)->pluck('fcm_token')->toArray();
                        if (count($tokens)) {

                            $send = notifyByFirebase($title, $body, $tokens, $data = ["Suiiz" => "Suiiz"]);

                        }
                    }
                }

                // $notification = $product->user->notifications()->create([

                //         'title'     => ['en' => 'product has been rejected', 'ar' => 'تم رفض الطلب'],
                //         'content'   => ['en' => $request->rejected_reason, 'ar' => $request->rejected_reason],

                // ]);

                // $tokens = $product->user()->where('fcm_token','!=', null)->pluck('fcm_token')->toArray();

                // if ( count($tokens) )
                // {
                //     $title = $notification->getTranslation('title', $product->user->lang);
                //     $body = $notification->getTranslation('content', $product->user->lang);

                //     $send = notifyByFirebase($title,$body,$tokens,$data = null);

                // }
            }

            return back()->with('status', "approve successfully");
        }

    }

    /**
     * @param $id
     */
    public function approve($id)
    {
        $product = Product::find($id);

        if ($product) {
            $product->status = "approve";

            if ($product->user()->exists()) {
                $lang = $product->user->lang;
                if ($lang == 'en') {

                    $title = 'Suiiz Support';
                    $body = 'Your ad has been successfully approved. You can view it right now, thank you.';

                } else {

                    $title = 'Suiiz الدعم الفني لدي';
                    $body = '.تمت الموافقة علي اعلانك بنجاح. يمكنك الاطلاع عليه الان, شكرا';

                }
                if ($product->save()) {
                    $tokens = $product->user()->where('fcm_token', '!=', null)->pluck('fcm_token')->toArray();
                    $send = notifyByFirebase($title, $body, $tokens, $data = ["Suiiz" => "Suiiz"]);
                }
            }

            return back()->with('status', "approve successfully");
        }

    }
    ///////////////////////////////////////////////////

    /**
     * @param $id
     */
    public function finished($id)
    {
        $product = Product::find($id);
        if ($product) {
            $product->status = "finished";
            $product->save();
            return back()->with('status', "finished successfully");
        }

    }
////////////////////////////search for product///////////////////////////////////////////////////////////////////////////

    /**
     * @param Request $request
     */
    public function searchs(Request $request)
    {

        $products = Product::where('status', $request->status)->get();
        return view('web.admin.products.index', compact('products'));
    }

//////start productsofcategoryi ///////////////

    /**
     * @param $id
     */
    public function productsofcategoryindex($id)
    {

        $products = Product::where('category_id', $id)->where('status', 'approve')->orderby('position', 'desc')->paginate(30);
        $skipped = ($products->currentPage() * $products->perPage()) - $products->perPage();

        $category_parent = Category::findOrFail($id);
        $category_id = $id;
        // return $products;

        return view('web.admin.products_category.index', compact('products', 'category_id', 'category_parent', 'skipped'));

    }

    /**
     * @param Request $request
     */
    public function productOfCategorySearch(Request $request)
    {

        $query = $request->input('query');
        $products = Product::search($query)->where('category_id', $request->category_id)->where('status', 'approve')->paginate(30);
        $skipped = ($products->currentPage() * $products->perPage()) - $products->perPage();
        $category_id_url = $request->category_id;
        if ($products->count()) {
            $category_parent = Category::findOrFail($products->first()->category_id);
            $category_id = $products->first()->category_id;
        } else {
            $category_parent = '';
            $category_id = '';

        }
        return view('web.admin.products_category.search-results', compact('products', 'skipped', 'category_id', 'category_id_url', 'category_parent'));

    }

    /**
     * @param $id
     */
    public function productofcatrgorycreate($id)
    {

        // $last_Level = View::where('name', 'last_leve')->id;
        $category = Category::find($id);
        $filters = FilterRecurring::orderBy('position', 'asc')->whereHas('categories', function ($q) use ($id) {
            $q->where('category_id', $id);

        })->get();
        $product_organization_selected = Product::where('category_id', $id)->orderBy('id', 'DESC')->first();
        $category_id = $id;

        if ($product_organization_selected) {
            $phone = $product_organization_selected->phone;
            if ($product_organization_selected->organization_name == "company") {
                if ($product_organization_selected->organization()->exists()) {
                    $view_selected = $product_organization_selected->organization()->first()->name;
                } else {
                    $view_selected = '';
                }
            } else {
                $view_selected = '';
            }

            $organization_name = $product_organization_selected->organization_name;
        } else {
            $organization_name = '';
            $view_selected = '';
            $phone = '';
        }

        return view('web.admin.products_category.create', compact('filters', 'category_id', 'organization_name', 'view_selected', 'phone'));
    }

    /**
     * @param ProductRequest $request
     * @param $id
     */
    public function productofcatrgorystore(ProductRequest $request, $id)
    {

        $user = User::where('mobile', $request->phone)->first();
        $count = Product::max('position');
        if ($request->organization == "personal") {
            $request->organization_id = null;
            $user_name = null;
            $email = null;
        }
        $product = new Product;
        $product->name = ['en' => $request->name_en, 'ar' => $request->name_ar];
        $product->description = $request->description;
        $product->link = $request->link;
        $product->price = $request->price;
        $product->discount = $request->discount;
        $product->status = "approve";
        $product->category_id = $id;
        $product->city_id = $request->city_id;
        $product->phone = $request->phone;
        $product->byadmin = 1;
        $product->latitude = $request->lat;
        $product->longitude = $request->lng;
        $product->contact = $request->contact;
        $product->user_id = null;
        $product->note = ['en' => $request->note_en, 'ar' => $request->note_ar];
        $product->organization_id = $request->organization_id;
        $product->organization_name = $request->organization;
        $product->quantity = $request->quantity;
        $product->position = $count + 1;
        $product->save();
        if ($product->organization()->exists()) {
            $product->username = $product->organization()->first()->name;
            $product->email = $product->organization()->first()->name;
            $product->save();
        }

        if ($request['sub_filter']) {
            $product->subFilters()->attach($request->sub_filter);
        }

        if ($request->has('document') && count($request->document) > 0) {
            $product->update(['images' => $request->document]);

        }

        if ($request->has('sub_properties')) {
            for ($i = 0; $i < count($request->sub_properties); $i++) {

                ProductSubProperty::create([
                    'product_id' => $product->id,
                    'sub_property_id' => $request->sub_properties[$i],
                    'price' => $request->property_price[$i],
                ]);

            }
        }

        if ($user) {
            $product->user_id = $user->id;
            $product->verify_phone = (integer) 1;
            $product->marketer_code_id = $user->marketer_code_id;
            $product->update();
        }

        return back()->with('status', 'Added successfully.');
    }

    /**
     * @param $id
     */
    public function productofcatrgoryedit($id)
    {

        $parent_categories = Category::where('parent_id', 0)->get();
        $product = Product::findorfail($id);
        $category_id = $product->category_id;
        $category = Category::find($category_id);

        $filters = FilterRecurring::orderBy('position', 'asc')->whereHas('categories', function ($q) use ($id, $product) {
            $q->where('category_id', $product->category_id);

        })->get();
        $selected = '';
        if ($product->organization()->exists()) {
            $selected = $product->organization()->first()->id;
        }

        return view('web.admin.products_category.edit', compact('product', 'selected', 'parent_categories', 'category_id', 'filters'));

    }

    /**
     * @param ProductRequest $request
     * @param $id
     */
    public function productofcatrgoryupdate(ProductRequest $request, $id)
    {

        if ($request->organization == "personal") {
            $request->organization_id = null;
        }
        $product = Product::find($id);
        $product->note = ['en' => $request->note_en, 'ar' => $request->note_ar];
        $product->name = $request->name;
        $product->price = $request->price;
        $product->discount = $request->discount;
        $product->description = $request->description;
        $product->organization_id = $request->organization_id;
        $product->organization_name = $request->organization;
        $product->category_id = $product->category_id;
        $product->name = ['en' => $request->name_en, 'ar' => $request->name_ar];
        $product->city_id = $request->city_id;
        $product->phone = $request->phone;
        $product->link = $request->link;
        $product->images = $request->document;
        $product->save();

        $product->subFilters()->sync($request->sub_filter);

        ProductSubProperty::where('product_id', $product->id)->forceDelete();

        if ($request->has('sub_properties')) {
            for ($i = 0; $i < count($request->sub_properties); $i++) {

                ProductSubProperty::create([

                    'product_id' => $product->id,
                    'sub_property_id' => $request->sub_properties[$i],
                    'price' => $request->property_price[$i],

                ]);

            }
        }

        return back()->with('status', '  Updated successfully.');

    }

    // public function searchproductofcategory(Request $request,$id)
    // {

    //   $products = Product::where('status',$request->status)->orderBy('id', 'DESC')->paginate(2000);
    //   $category_id = $id;

    //   return view('web.admin.products_category.index',compact('products','category_id'));

    // }

    //end productsofcategoryi
    //start product dashboad
    public function productofdashboardindex()
    {

        $products = Product::paginate(30);
        $skipped = ($products->currentPage() * $products->perPage()) - $products->perPage();

        return view('web.admin.products_dashboard.index', compact('products', 'skipped'));
    }

    public function productofdashboardfinish()
    {

        $products = Product::whereNull('user_id')->where('status', '=', 'finished')->orderby('position', 'desc')->get();
        return view('web.admin.products_dashboard.finsih', compact('products'));

    }

    public function productofmobileindex()
    {

        $products = Product::whereNotNull('user_id')->where('status', '!=', 'finished')->orderby('position', 'desc')->get();
        return view('web.admin.products_mobile.index', compact('products'));

    }

    public function productMobileFinish()
    {
        $products = Product::whereNotNull('user_id')->where('status', '=', 'finished')->orderby('position', 'desc')->get();
        return view('web.admin.products_mobile.finsih', compact('products'));
    }

    public function productMobileApprove()
    {
        $products = Product::whereNotNull('user_id')->where('status', '=', 'approve')->orderby('position', 'desc')->paginate(20);
        $skipped = ($products->currentPage() * $products->perPage()) - $products->perPage();

        return view('web.admin.products_mobile.approve', compact('products', 'skipped'));
    }

    public function approveMobilePaginate(Request $request)
    {
        if ($request->ajax()) {
            $sort_by = $request->get('sortby');
            $sort_type = $request->get('sorttype');
            $query = $request->get('query');
            $products = Product::whereNotNull('user_id')->where('status', '=', 'approve')->orderby('position', 'desc')->paginate(20);

            $query = str_replace(" ", "%", $query);
            $skipped = ($products->currentPage() * $products->perPage()) - $products->perPage();
        }
        return view('web.admin.products_mobile.pagination_data', compact('products', 'skipped'))->render();

    }
    public function approveMobilePaginateResult(Request $request)
    {
        if ($request->ajax()) {
            $sort_by = $request->get('sortby');
            $sort_type = $request->get('sorttype');
            $search = $request->get('search');
            $query = str_replace(" ", "%", $search);
            $products = Product::search($query)->whereNotNull('user_id')->where('status', '=', 'approve')->orderby('position', 'desc')->paginate(20);

            $skipped = ($products->currentPage() * $products->perPage()) - $products->perPage();
        }
        return view('web.admin.products_mobile.pagination_data', compact('products', 'skipped'))->render();

    }
    public function productMobileDisapprove()
    {
        $products = Product::whereNotNull('user_id')->where('status', '=', 'disapprove')->orderby('position', 'desc')->get();
        return view('web.admin.products_mobile.disapprove', compact('products'));
    }

    public function productMobilePennding()
    {
        $products = Product::whereNotNull('user_id')->where('status', '=', 'pennding')->orderby('position', 'desc')->get();
        return view('web.admin.products_mobile.pennding', compact('products'));
    }

    /**
     * @param $id
     */
    public function trashOfCategory($id)
    {
        $products = Product::onlyTrashed()->where('category_id', $id)->orderby('deleted_at')->orderby('position', 'desc')->get();
        $category_id = $id;
        return view('web.admin.products_category.trash', compact('products', 'category_id'));
    }

    public function trashFinshProduct()
    {
        $products = Product::onlyTrashed()->whereNull('user_id')->where('status', 'finished')->orderby('deleted_at')->orderby('position', 'desc')->get();
        $by_admin = 'finish_dashboard';
        return view('web.admin.products_dashboard.trash', compact('products', 'byadmin'));
    }

    public function trashPenndingProduct()
    {
        $products = Product::onlyTrashed()->whereNotNull('user_id')->where('status', 'pennding')->orderby('deleted_at')->orderby('position', 'desc')->get();
        $by_admin = 'products_pennding';
        return view('web.admin.products_mobile.trash', compact('products', 'by_admin'));
    }

    public function trashDisapproveProduct()
    {
        $products = Product::onlyTrashed()->whereNotNull('user_id')->where('status', 'disapprove')->orderby('deleted_at')->orderby('position', 'desc')->get();
        $by_admin = 'products_disapprove';
        return view('web.admin.products_mobile.trash', compact('products', 'by_admin'));
    }

    public function trashApproveProduct()
    {
        $products = Product::onlyTrashed()->whereNotNull('user_id')->where('status', 'approve')->orderby('deleted_at')->orderby('position', 'desc')->get();
        $by_admin = 'products_approve';
        return view('web.admin.products_mobile.trash', compact('products', 'by_admin'));
    }

    public function trashFinishMobileProduct()
    {
        $products = Product::onlyTrashed()->whereNotNull('user_id')->where('status', 'fin')->orderby('deleted_at')->orderby('position', 'desc')->get();
        $by_admin = 'products_finished';
        return view('web.admin.products_mobile.trash', compact('products', 'by_admin'));
    }

    // to force delete a product
    /**
     * @param $id
     */
    public function forceDestroy($id)
    {
        $product = Product::onlyTrashed()->find($id);
        $product->forceDelete();
        return back()->with('status', "Deleted successfully");
    }

    // to force delete all products
    /**
     * @param Request $request
     */
    public function forceDestroyAll(Request $request)
    {
        $force_delete_all_ids = explode(",", $request->force_delete_all_id);
        $products = Product::onlyTrashed()->whereIn('id', $force_delete_all_ids)->orderby('position', 'desc')->get();
        foreach ($products as $product) {
            $product->forceDelete();
        }

        return back()->with('status', "Deleted successfully");
    }

    // to restore a product
    /**
     * @param $id
     */
    public function restore($id)
    {
        $product = Product::onlyTrashed()->find($id);
        $product->restore();

        return back()->with('status', "Product has been restored successfully");
    }

    // to restore all products
    /**
     * @param Request $request
     */
    public function restoreAll(Request $request)
    {

        if ($request->restores_ids) {

            $restores_ids = explode(",", $request->restores_ids);
            if (in_array('on', $restores_ids)) {
                array_shift($restores_ids);
            }
            Product::onlyTrashed()->whereIn('id', $restores_ids)->restore();
        }

        return back()->with('status', "Products has been restored successfully");
    }

    // to sort the products
    /**
     * @param  Request $request
     * @return int
     */
    public function sortable(Request $request)
    {

        if (count($request->order) > 0) {
            $position = Product::whereIn('id', $request->order)->min('position');
            // Update sort position
            foreach ($request->order as $id) {
                $product = Product::find($id);
                $product->position = $position;
                $product->update();
                $position++;
            }
            return 1;
        } else {
            return 0;
        }
    }

    // to sort images of product
    /**
     * @param  Request $request
     * @return int
     */
    public function sortImages(Request $request)
    {

        if (count($request->imageids) > 0) {
            // Update sort position of images
            $position = 1;
            foreach ($request->imageids as $id) {
                $image = MediaCenter::find($id);
                $image->order_column = $position;
                $image->update();
                $position++;
            }
            return 1;

        } else {

            return 0;
        }
    }

    // to delete image
    /**
     * @param  Request $request
     * @return int
     */
    public function deleteImage(Request $request)
    {
        $media = MediaCenter::find($request->image_id);

        if ($media) {

            \Storage::disk('s3')->delete($media->file_name);
            if ($media->forceDelete()) {
                return 1;

            } else {
                return 0;

            }
        }
    }
    /**
     * PaginateResultSearch
     *
     * @param  Illuminate\Http\Request $request
     * @return view
     */
    public function PaginateResultSearch(Request $request)
    {
        if ($request->ajax()) {
            $sort_by = $request->get('sortby');
            $sort_type = $request->get('sorttype');
            $search = $request->get('search');
            $query = str_replace(" ", "%", $search);
            $products = Product::search($search)->where('category_id', $request->category_id)->where('status', 'approve')->orderby('position', 'desc')->paginate(30);
            $category_parent = Category::findOrFail($request->category_id);
            $skipped = ($products->currentPage() * $products->perPage()) - $products->perPage();
            return view('web.admin.products_category.pagination_data', compact('products', 'skipped', 'category_parent'))->render();
        }

    }
    // to productReview
    /**
     * @param $id
     */
    public function productReview($id)
    {

        $product = Product::find($id);
        $city_name = $product->city()->exists() ? $product->city->name : 'Cairo';
        $governorate_name = $product->city()->exists() ? $product->city->governorate->name : 'Egypt';

        $subFiltersIds = $product->subFilters()->orderby('position', 'asc')->pluck('sub_filter_recurring_id');
        $filtersIds = $product->subFilters()->orderby('position', 'asc')->pluck('filter_recurring_id');

        $filters = FilterRecurring::orderby('position', 'asc')->whereIn('id', $filtersIds)->with(array('subFiltersRecurring' => function ($q) use ($subFiltersIds) {
            $q->whereIn('id', $subFiltersIds)->orderby('position');

        }))->get();

        if ($product->category()->exists()) {
            $categories = [];
            if ($product->category->getParentsNames() !== $product->category->name) {
                foreach ($product->category->getParentsNames()->reverse() as $item) {
                    array_push($categories, $item->name);
                }
            }
            array_push($categories, $product->category->name);
        }

        // $categories=['new'];
        $images = $product->images->sortBy('order_column');

        // $images = $product->medias()->orderby('position')->get();

        return response()->json([
            'product' => $product,
            'city_name' => $city_name,
            'governorate_name' => $governorate_name,
            'filters' => $filters,
            'images' => $images,
            'categories' => $categories,
        ]);

    }
    /**
     * @param Request $request
     */
    public function search(Request $request)
    {

        $query = $request->input('query');
        $products = Product::search($query)->orderBy('id', 'DESC')->paginate(50);
        $skipped = ($products->currentPage() * $products->perPage()) - $products->perPage();
        return view('web.admin.products_dashboard.search-results', compact('products', 'skipped'));
    }
    public function searchProductMobileApprove(Request $request)
    {

        $query = $request->input('query');
        $products = Product::search($query)->whereNotNull('user_id')->where('status', '=', 'approve')->orderBy('id', 'DESC')->paginate(20);

        $skipped = ($products->currentPage() * $products->perPage()) - $products->perPage();
        return view('web.admin.products_mobile.search-results', compact('products', 'skipped'));
    }

    /**
     * @param Request $request
     */
    public function fetch_data(Request $request)
    {
        if ($request->ajax()) {
            $sort_by = $request->get('sortby');
            $sort_type = $request->get('sorttype');
            $query = $request->get('query');
            $query = str_replace(" ", "%", $query);
            $products = Product::where('category_id', $request->category_id)->where('status', 'approve')->orderby('position', 'desc')->paginate(30);
            $category_parent = Category::findOrFail($request->category_id);
            $skipped = ($products->currentPage() * $products->perPage()) - $products->perPage();
            return view('web.admin.products_category.pagination_data', compact('products', 'skipped', 'category_parent'))->render();
        }

    }
    /**
     * @param Request $request
     */

    /**
     * @param Request $request
     */
    public function ProductfetchData(Request $request)
    {

        if ($request->ajax()) {
            $sort_by = $request->get('sortby');
            $sort_type = $request->get('sorttype');
            $query = $request->get('query');
            $products = Product::where('price', 'like', '%' . $query . '%')->orderby('position', 'desc')->paginate(30);
            $query = str_replace(" ", "%", $query);
            $skipped = ($products->currentPage() * $products->perPage()) - $products->perPage();
            return view('web.admin.products_category.pagination_data', compact('products', 'skipped'))->render();
        }

    }
    // public function show($id)
    // {

    // }
    public function ajaxPenddingMobile()
    {
        $products = Product::whereNotNull('user_id')->where('status', '=', 'pennding')->orderby('position', 'desc')->with(['user', 'category'])->get();
        $response = [
            'status' => 1,
            'message' => 'success',
            'data' => $products,
        ];
        return response()->json($response);

    }
}
