<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Web\Admin\CategoryRecurringRequest;
use App\Http\Requests\Web\Admin\subCategoryRecurring;
use App\Models\CategoryRecurring;
use App\Models\FilterRecurring;
use App\Models\Category;
use App\Models\Account;
use App\Models\View;

class RecurringSubCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:recurring_category_category_types', ['only' => ['index']]);
        $this->middleware('permission:create_recurring_categories', ['only' => ['create','store']]);
        $this->middleware('permission:update_recurring_categories', ['only' => ['edit','update']]);
        $this->middleware('permission:delete_recurring_categories', ['only' => ['destroy']]);


        $this->middleware('permission:subRecurringCategories', ['only' => ['subRecurringCategories.index']]);
        $this->middleware('permission:create_sub_recurring_categories', ['only' => ['subRecurringCategories.create','subRecurringCategories.store']]);
        $this->middleware('permission:update_sub_recurring_categories', ['only' => ['subRecurringCategories.edit','subRecurringCategories.update']]);
        $this->middleware('permission:delete_sub_recurring_categories', ['only' => ['subRecurringCategories.destroy']]);
        $this->middleware('permission:all_sub_recurring_categories', ['only' => ['toggle_all_sub_recuring']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $recurringSubCategories = CategoryRecurring::where('parent_id', 0)->where('category_type_id', $id)->orderby('position')->get();
        $parentCategories = Category::where('parent_id', 0)->get();
        $category_type_id = $id;

        return view('web.admin.recurringSubCategories.index', compact('recurringSubCategories', 'parentCategories', 'category_type_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $category_type_id = $id;

        $recurringSubCategories = CategoryRecurring::where('parent_id', 0)->latest()->first();
        if ($recurringSubCategories) {
            $last_view=$recurringSubCategories->view()->first()->name;
        } else {
            $last_view='';
        }
        $views = View::all();
        $accounts = Account::all();
        $parentCategories = Category::where('parent_id', 0)->get();
        return view('web.admin.recurringSubCategories.create', compact('accounts', 'parentCategories', 'views', 'last_view', 'category_type_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRecurringRequest $request)
    {
        $recurring_category = new CategoryRecurring;


        $recurring_category->name = ['en' => $request->name_en , 'ar' => $request->name_ar] ;
        $recurring_category->view_id = $request->view_id ;
        $recurring_category->description = ['en' => $request->description_en , 'ar' => $request->description_ar] ;

        $recurring_category->text1 = ['en' => $request->text1_en , 'ar' => $request->text1_ar];
        $recurring_category->text2 = ['en' => $request->text2_en , 'ar' => $request->text2_ar];
        $recurring_category->category_type_id = $request->category_type_id;


        if ($request->has('document')) {
            $image=$request->document;
            $recurring_category->image='uploads/categories/'.$image;
            $recurring_category->save();
        }

        $recurring_category->position = $recurring_category->id;
        $recurring_category->save();

        $recurring_category->position = $recurring_category->id;
        $recurring_category->update();
        $recurring_category->subAccounts()->attach($request->sub_account);

        foreach ($request->categories_list as $category_id) {
            $category = $recurring_category->categories()->create([

                'name'          => ['en' => $request->name_en , 'ar' => $request->name_ar],
                'parent_id'   => $category_id,
                'description' => ['en' => $request->description_en , 'ar' => $request->description_ar],
                'view_id' => $request->view_id,
            ]);
            if ($request->has('document')) {
                $image=$request->document;
                $category->image='uploads/categories/'.$image;
                $category->save();

                $category->position = $category->id;
                $category->update();
            }




            $category->subAccounts()->attach($request->sub_account);
        }

        session()->flash('Add', 'تم أضافة السجل بنجاح ');
        return redirect(route('recurring_category.index', $request->category_type_id));
    }


    public function edit(CategoryRecurring $recurring_category)
    {
        // $recurring_category = CategoryRecurring::find($id);
        $views = View::all();
        $accounts = Account::all();
        $parentCategories = Category::where('parent_id', 0)->get();
        $sub_accounts_id_of_recurring_category = $recurring_category->subAccounts->pluck('id');
        $categories_id = $recurring_category->categories()->pluck('parent_id');

        return view('web.admin.recurringSubCategories.edit', compact('accounts', 'parentCategories', 'views', 'sub_accounts_id_of_recurring_category', 'categories_id', 'recurring_category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRecurringRequest $request, CategoryRecurring $recurring_category)
    {
        $recurring_category->ategory_type_id;
        $recurring_category = CategoryRecurring::find($recurring_category->id);


        if ($request->has('document')) {
            $image=$request->document;
            $recurring_category->image='uploads/categories/'.$image;
        }


        $recurring_category->name = ['en' => $request->name_en , 'ar' => $request->name_ar];
        $recurring_category->view_id = $request->view_id ;
        $recurring_category->description = ['en' => $request->description_en , 'ar' => $request->description_ar] ;

        $recurring_category->text1 = ['en' => $request->text1_en , 'ar' => $request->text1_ar];
        $recurring_category->text2 = ['en' => $request->text2_en , 'ar' => $request->text2_ar];
        $recurring_category->save();

        $recurring_category->subAccounts()->sync($request->sub_account);
        $categories_id_of_old_categories = $recurring_category->categories()->pluck('parent_id');


        foreach ($categories_id_of_old_categories as $category) {
            if (! in_array($category, $request->categories_list)) {
                $categories = $recurring_category->categories()->where('parent_id', $category)->first();
                // $categories->subAccounts()->detach();
                $categories->delete();
            }
        }

        $categories_id_of_old_categories_now = $recurring_category->categories()->pluck('parent_id');

        foreach ($request->categories_list as $category_id) {
            if (in_array($category_id, json_decode($categories_id_of_old_categories_now))) {
                $categories = $recurring_category->categories()->where('parent_id', $category_id)->first();

                $categories->update([

                    'name'          => ['en' => $request->name_en , 'ar' => $request->name_ar],
                    'parent_id'   => $category_id,
                    'description' => ['en' => $request->description_en , 'ar' => $request->description_ar],
                    'view_id' => $request->view_id,

                ]);


                if ($request->has('document')) {
                    $image=$request->document;
                    $categories->image='uploads/categories/'.$image;

                    $categories->save();
                }

                $categories->subAccounts()->sync($request->sub_account);
            } else {
                $category = $recurring_category->categories()->withTrashed()->where('parent_id', $category_id);

                if ($category->count()) {
                    $category->restore();
                // $category->first()->subAccounts()->attach($request->sub_account);
                } else {
                    $category = $recurring_category->categories()->create([

                        'name'          => ['en' => $request->name_en , 'ar' => $request->name_ar],
                        'parent_id'     => $category_id,
                        'description'   => ['en' => $request->description_en , 'ar' => $request->description_ar],
                        'image'         => $recurring_category->image,
                        'view_id'       => $request->view_id,

                    ]);

                    $category->subAccounts()->attach($request->sub_account);

                    if ($recurring_category->recurringChilds->count()) {
                        updateRecurringCategory($recurring_category->id, $category->id);
                    }
                }
            }
        }

        session()->flash('edit', 'تم تعديل السجل بنجاح ');
        return redirect(route('recurring_category.index', $recurring_category->category_type_id));
    }



    public function destroy(CategoryRecurring $recurring_category)
    {
        $recurring_category->delete();
        return back()->with('delete', "تم حذف سجل بنجاح");
    }


    public function destroyAll(Request $request)
    {
        $delete_all_ids = explode(",", $request->delete_all_id);
        $recurring_categories = CategoryRecurring::whereIn('id', $delete_all_ids)->get();

        foreach ($recurring_categories as $recurring_category) {
            $recurring_category->delete();
        }


        return back()->with('delete', "تم حذف السجلات بنجاح");
    }

    public function subRecurringIndex($recurring_category)
    {
        $subRecurringSubCategory = CategoryRecurring::where('id', $recurring_category)->first();
        $Recurrings = CategoryRecurring::where('id', $recurring_category)->first();

        if ($subRecurringSubCategory->count()) {
            $parent=$subRecurringSubCategory;
        } else {
            $parent='';
        }
        $subRecurringSubCategories = CategoryRecurring::where('parent_id', $subRecurringSubCategory->id)->orderby('position')->paginate(200);

        $parentCategories = Category::where('parent_id', 0)->get();

        return view('web.admin.recurringSubCategories.subRecurringSubCategories.index', compact('subRecurringSubCategories', 'subRecurringSubCategory', 'parentCategories', 'parent', 'Recurrings'));
    }

    public function subRecurringCreate(CategoryRecurring $subRecurringSubCategory)
    {
        $subRecurringSub = CategoryRecurring::where('id', $subRecurringSubCategory->id)->get();
        $order_by=CategoryRecurring::orderBy('id', 'desc')->get();







        if ($subRecurringSub) {
            $parent = CategoryRecurring::where('id', $subRecurringSubCategory->id)->get();
        } else {
            $parent='';
            $last_view='';
        }

        if ($subRecurringSub->count()) {
            $last_view=CategoryRecurring::orderBy('id', 'desc')->first()->view()->first()->name;
        } else {
            $last_view='';
        }

        $views = View::all();
        $accounts = Account::all();
        $parentCategories = Category::where('parent_id', 0)->get();
        return view('web.admin.recurringSubCategories.subRecurringSubCategories.create', compact(
            'subRecurringSubCategory',
            'accounts',
            'parentCategories',
            'views',
            'last_view',
            'parent'
        ));
    }


    public function subRecurringStore(Request $request, CategoryRecurring $subRecurringSubCategory)
    {
        $subRecurringCategory = new CategoryRecurring;
        $subRecurringCategory->name = ['en' => $request->name_en , 'ar' => $request->name_ar] ;
        $subRecurringCategory->view_id = $request->view_id ;
        $subRecurringCategory->description = ['en' => $request->description_en , 'ar' => $request->description_ar] ;

        $subRecurringCategory->text1 = ['en' => $request->text1_en , 'ar' => $request->text1_ar];
        $subRecurringCategory->text2 = ['en' => $request->text2_en , 'ar' => $request->text2_ar];
        $subRecurringCategory->parent_id = $subRecurringSubCategory->id ;
        $subRecurringCategory->save();

        if ($request->document) {
            $image=$request->document;
            $subRecurringCategory->image ='uploads/categories/'.$image;
            $subRecurringCategory->save();
        }


        $subRecurringCategory->position = $subRecurringCategory->id;
        $subRecurringCategory->update();

        $subRecurringCategory->subAccounts()->attach($request->sub_account);

        $categories_id = $subRecurringSubCategory->categories->pluck('id');

        foreach ($categories_id as $parent_id) {
            $category = new Category;

            $category->name = ['en' => $request->name_en , 'ar' => $request->name_ar] ;
            $category->description = ['en' => $request->description_en , 'ar' => $request->description_ar];
            $category->parent_id = $parent_id;
            $category->view_id = $request->view_id;
            $category->category_recurring_id = $subRecurringCategory->id;
            if ($request->document) {
                $image=$request->document;
                $category->image='uploads/categories/'.$image;
            }
            $category->save();

            $category->position = $category->id;
            $category->update();

            $category->subAccounts()->attach($request->sub_account);
        }

        session()->flash('Add', 'تم أضافة السجل بنجاح ');
        return redirect(route('subRecurringCategories.index', $subRecurringSubCategory));
    }


    public function subRecurringEdit(CategoryRecurring $subRecurringSubCategory)
    {
        $recurring_category = CategoryRecurring::find($subRecurringSubCategory->id);

        $parent = CategoryRecurring::where('id', $recurring_category->parent_id)->first();


        if ($parent) {
            $parent = CategoryRecurring::where('id', $recurring_category->parent_id)->first();
        } else {
            $parent='';
            $last_view='';
        }
        $views = View::all();
        $accounts = Account::all();
        return view('web.admin.recurringSubCategories.subRecurringSubCategories.edit', compact(
            'subRecurringSubCategory',
            'accounts',
            'views',
            'parent'
        ));
    }

    public function subRecurringUpdate(subCategoryRecurring $request, CategoryRecurring $subRecurringSubCategory)
    {
        $recurring_category = CategoryRecurring::find($subRecurringSubCategory->id);

        $recurring_category_id = CategoryRecurring::where('parent_id', '!=', 0)->find($subRecurringSubCategory->id);


        $recurring_category_back = CategoryRecurring::where('id', $recurring_category->parent_id);



        $subRecurringSubCategory->name = ['en' => $request->name_en , 'ar' => $request->name_ar] ;
        $subRecurringSubCategory->view_id = $request->view_id ;
        $subRecurringSubCategory->text1 = ['en' => $request->text1_en , 'ar' => $request->text1_ar];
        $subRecurringSubCategory->text2 = ['en' => $request->text2_en , 'ar' => $request->text2_ar];
        $subRecurringSubCategory->description = ['en' => $request->description_en , 'ar' => $request->description_ar] ;
        $subRecurringSubCategory->save();


        if ($request->has('document')) {
            $image=$request->document;
            $subRecurringSubCategory->image='uploads/categories/'.$image;
            $subRecurringSubCategory->save();
        }


        $subRecurringSubCategory->subAccounts()->sync($request->sub_account);

        $categories_id = $subRecurringSubCategory->categories->pluck('id');

        foreach ($categories_id as $category) {
            $categories = $subRecurringSubCategory->categories()->where('id', $category)->first();

            $categories->update([

                    'name'          => ['en' => $request->name_en , 'ar' => $request->name_ar],
                    // 'parent_id'   => $category_id,
                    'description' => ['en' => $request->description_en , 'ar' => $request->description_ar],
                    'view_id' => $request->view_id,
                ]);

            if ($request->has('document')) {
                $image=$request->document;
                $categories->image='uploads/categories/'.$image;
            }
            $categories->update();

            $categories->subAccounts()->sync($request->sub_account);
        }


        session()->flash('edit', 'تم تعديل السجل بنجاح ');
        return redirect(route('subRecurringCategories.index', $subRecurringSubCategory->parent_id));
    }

    public function subRecurringDestroy(CategoryRecurring $subRecurringSubCategory)
    {
        $subRecurringSubCategory->delete();
        return back()->with('delete', "تم حذف سجل بنجاح");
    }



    ////////////////save image in folder  in create image from dropzone
    public function recuringsaveImages(Request $request)
    {
        $file = $request->file('dzfile');
        $filename = uploadImageToS3('categories', $file);

        return response()->json([
            'name' => $filename,
            'original_name' => $file->getClientOriginalName(),
        ]);
    }


    ////////////////delete image from database in edit dropzone

    ////////all_sub_categories

    public function toggleAll_subrecuring($id)
    {
        $sub_recuring = CategoryRecurring::find($id);


        if ($sub_recuring->is_all) {
            $sub_recuring->categories()->update(['is_all' => 0 ]);
            $sub_recuring->is_all = 0;
            $sub_recuring->update();
        } else {
            $sub_recuring->categories()->update([ 'is_all' => 1 ]);
            $sub_recuring->is_all = 1;
            $sub_recuring->update();
        }

        return redirect()->back();
    }



    public function sortable(Request $request)
    {
        // return $request;
        $categories = CategoryRecurring::all();

        foreach ($categories as $category) {
            $category->timestamps = false; // To disable update_at field updation
            $id = $category->id;

            foreach ($request->order as $key => $order) {
                if ($key > 0) {
                    if ($order['id'] == $id) {
                        $category->update(['position' => $order['position']]);
                    }
                }
            }
        }

        return response('Update Successfully.', 200);
    }

    // to get all trashed categories
    public function trash($id = null)
    {
        $cat_id = $id ? $id : 0;
        $categories = CategoryRecurring::onlyTrashed()->where('parent_id', $cat_id)->orderby('deleted_at')->paginate(200);
        $category_id = $cat_id;

        return view('web.admin.recurringSubCategories.trash', compact('categories', 'category_id'));
    }

    // to restore a category
    public function restore($id)
    {
        $category = CategoryRecurring::onlyTrashed()->find($id);
        $category->restore();

        return back()->with('status', "CategoryRecurring has been restored successfully");
    }

    // to restore all categories
    public function restoreAll(Request $request)
    {
        $arr = array();

        $restores_ids = explode(",", $request->restores_ids);
        $categories = CategoryRecurring::onlyTrashed()->whereIn('id', $restores_ids)->get();
        foreach ($categories as $category) {
            $category->restore();
        }



        return back()->with('status', "Categories has been restored successfully");
    }

    // // to force delete a category
    // public function forceDestroy($id)
    // {
    //     $category = CategoryRecurring::onlyTrashed()->find($id);

    //     $category->forceDelete();


    //     return back()->with('status',"Deleted successfully");
    // }

    // // to force delete all categories
    // public function forceDestroyAll(Request $request)
    // {
    //     $force_delete_all_ids = explode(",", $request->force_delete_all_id);
    //     $products = Product::onlyTrashed()->whereIn('id', $force_delete_all_ids)->get();

    //     foreach( $products as $product)
    //     {
    //         foreach($product->medias()->get() as $media)
    //         {
    //         \Storage::disk('products')->delete($media->url);
    //         }
    //         $product->medias()->forceDelete();
    //         $product->supFilter()->detach();
    //         $product->forceDelete();
    //     }

    //     return back()->with('status',"Deleted successfully");
    // }
}
