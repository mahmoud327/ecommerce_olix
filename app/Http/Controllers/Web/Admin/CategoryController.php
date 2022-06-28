<?php

namespace App\Http\Controllers\Web\Admin;

use App\Models\View;
use App\Models\Product;
use App\Models\Category;
use App\Models\Advertisment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Web\Admin\CategoryRequest;

class CategoryController extends Controller
{
    public function __construct()
    {

        // $this->middleware('permission:categories', ['only' => ['index']]);
        // $this->middleware('permission:create_category', ['only' => ['create','store']]);
        // $this->middleware('permission:update_category', ['only' => ['edit','update']]);
        // $this->middleware('permission:delete_category', ['only' => ['destroy']]);

        // $this->middleware('permission:sub_categories', ['only' => ['category.subCategories']]);
        // $this->middleware('permission:update_sub_categories', ['only' => ['category.subCategories.update']]);
        // $this->middleware('permission:create_sub_categories', ['only' => ['category.subCategories.store']]);
        // $this->middleware('permission:all_sub_categories', ['only' => ['category.subCategories.subDestroyAll']]);
        // $this->middleware('permission:delete_sub_categories', ['only' => ['category.subCategories.destroy']]);
        // $this->middleware('permission:create_product_from_categories', ['only' => ['product.productofcatrgorycreate']]);
        // $this->middleware('permission:show_filters_from_categories', ['only' => ['filters.index']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::where('parent_id', 0)->orderby('position')->with('view')->paginate(10);
        $skipped = ($categories->currentPage() * $categories->perPage()) - $categories->perPage();

        $advertisment = Advertisment::where('category_id', 1)->first();
        if ($categories->count()) {
            $last_categories = Category::where('parent_id', '0')->latest()->first();

            $last_view = $last_categories->view()->first()->name;
        } else {
            $last_categories = '';
            $last_view = '';
        }

        $views = View::all();

        return view('web.admin.categories.index', ['categories' => $categories, 'views' => $views, 'last_view' => $last_view, 'advertisment' => $advertisment, 'skipped' => $skipped]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request    $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $category = new Category();
        $category->name = ['en' => $request->name_en, 'ar' => $request->name_ar];
        $category->description = ['en' => $request->description_en, 'ar' => $request->description_ar];
        $category->view_id = $request->view_id;
        $category->text1 = ['en' => $request->text1_en, 'ar' => $request->text1_ar];
        $category->text2 = ['en' => $request->text2_en, 'ar' => $request->text2_ar];
        $category->save();
        if ($request->hasFile('image')) {
            $file_name = $request->file('image')->store('uploads/categories', 's3');
            Storage::disk('s3')->setVisibility($file_name, 'public');
            $category->image = $file_name;
        }

        $category->position = $category->id;
        $category->update();
        $category->subAccounts()->attach($request->sub_account);
        session()->flash('Add', 'تم اضافة سجل بنجاح ');
        return redirect()->back();
    }

    /**
     * @param Category $category
     */
    public function show(Category $category)
    {
        $subCategories = Category::where('parent_id', $category)->orderBy('id', 'desc')->get();
        $views = View::all();
        return view('web.admin.categories.', ['categories' => $categories, 'views' => $views]);
    }

    /**
     * @param CategoryRequest $request
     * @param Category        $category
     */
    public function update(CategoryRequest $request, Category $category)
    {
        if ($request->hasFile('image')) {
            Storage::disk('s3')->delete($category->image);
            $file_name = $request->file('image')->store('uploads/categories', 's3');
            Storage::disk('s3')->setVisibility($file_name, 'public');
            $category->image = $file_name;
            $category->update();
        }
        $category->name = ['en' => $request->name_en, 'ar' => $request->name_ar];
        $category->description = ['en' => $request->description_en, 'ar' => $request->description_ar];
        $category->view_id = $request->view_id;
        $category->text1 = ['en' => $request->text1_en, 'ar' => $request->text1_ar];
        $category->text2 = ['en' => $request->text2_en, 'ar' => $request->text2_ar];
        $category->update();
        $category->subAccounts()->sync($request->sub_account);
        session()->flash('Add', 'تم التعديل سجل بنجاح ');
        return redirect()->back();
    }

    /**
     * @param Category $category
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return back()->with('delete', "تم حذف سجل بنجاح");
    }

    /**
     * @param Request $request
     */
    public function delete_all(Request $request)
    {
        $delete_all_id = explode(",", $request->delete_all_id);
        $categories = Category::whereIn('id', $delete_all_id)->get();
        foreach ($categories as $category) {
            $category->delete();
        }
        return back()->with('status', "Deleted successfully");
    }

    // to force delete a category
    /**
     * @param $id
     */
    public function forceDestroy($id)
    {
        $category = Category::onlyTrashed()->find($id);
        $category->forceDelete();

        return back()->with('status', "Deleted successfully");
    }

    // to force delete all categories
    /**
     * @param Request $request
     */
    public function forceDestroyAll(Request $request)
    {
        $force_delete_all_ids = explode(",", $request->force_delete_all_id);
        $products = Product::onlyTrashed()->whereIn('id', $force_delete_all_ids)->get();
        foreach ($products as $product) {
            $product->supFilter()->detach();
            $product->forceDelete();
        }

        return back()->with('status', "Deleted successfully");
    }

    // to get all trashed categories
    /**
     * @param $id
     */
    public function trash($id = null)
    {
        $cat_id = $id ? $id : 0;
        $categories = Category::onlyTrashed()->where('parent_id', $cat_id)->orderby('deleted_at')->paginate(200);
        $category_id = $cat_id;

        return view('web.admin.categories.trash', compact('categories', 'category_id'));
    }

    // to restore a category
    /**
     * @param $id
     */
    public function restore($id)
    {
        $arr = array();
        $category = Category::onlyTrashed()->find($id);
        $category->restore();
        $category_ids = lastCategoriesIds($category->id, $arr);
        Product::whereIn('category_id', $category_ids)->onlyTrashed()->restore();

        return back()->with('status', "Category has been restored successfully");
    }

    // to restore all categories
    /**
     * @param Request $request
     */
    public function restoreAll(Request $request)
    {
        $restores_ids = explode(",", $request->restores_ids);
        $categories = Category::onlyTrashed()->whereIn('id', $restores_ids)->get();
        foreach ($categories as $category) {
            $arr = array();
            $category->restore();
            $category_ids = lastCategoriesIds($category->id, $arr);
            Product::whereIn('category_id', $category_ids)->onlyTrashed()->restore();
        }
        return back()->with('status', "Categories has been restored successfully");
    }

    /**
     * @param Category $category
     */
    public function getSubCategories(Category $category)
    {
        $subCategories = Category::where('parent_id', $category->id)->orderby('position')->paginate(10);
        $skipped = ($subCategories->currentPage() * $subCategories->perPage()) - $subCategories->perPage();
        if ($subCategories->count()) {
            $last_categories = Category::where('parent_id', $category->id)->latest()->first();
            $parent = Category::where('id', $subCategories->first()->parent_id)->first();
            $last_view = $last_categories->view()->first()->name;
        } else {
            $parent = '';
            $last_view = '';
        }
        $views = View::all();
        return view('web.admin.categories.subCategories.index', ['subCategories' => $subCategories, 'category' => $category, 'views' => $views, 'parent' => $parent, 'last_view' => $last_view, 'skipped' => $skipped]);
    }

    /**
     * @param Category        $category
     * @param CategoryRequest $request
     */
    public function subCategoryStore(Category $category, CategoryRequest $request)
    {
        $subCategory = new Category();
        if ($request->hasFile('image')) {
            $file_name = $request->file('image')->store('uploads/categories', 's3');
            Storage::disk('s3')->setVisibility($file_name, 'public');
            $subCategory->image = $file_name;
        }
        $subCategory->name = ['en' => $request->name_en, 'ar' => $request->name_ar];
        $subCategory->description = ['en' => $request->description_en, 'ar' => $request->description_ar];
        $subCategory->view_id = $request->view_id;
        $subCategory->parent_id = $category->id;
        $subCategory->text1 = ['en' => $request->text1_en, 'ar' => $request->text1_ar];
        $subCategory->text2 = ['en' => $request->text2_en, 'ar' => $request->text2_ar];
        $subCategory->save();
        $subCategory->position = $subCategory->id;
        $subCategory->update();
        $subCategory->subAccounts()->attach($request->sub_account);
        session()->flash('Add', 'تم اضافة سجل بنجاح ');
        return redirect()->back();
    }

    /**
     * @param Category        $subCategory
     * @param CategoryRequest $request
     */
    public function subCategoryUpdate(Category $subCategory, CategoryRequest $request)
    {
        if ($request->hasFile('image')) {
            $file_name = $request->file('image')->store('uploads/categories', 's3');
            Storage::disk('s3')->setVisibility($file_name, 'public');
            $subCategory->image = $file_name;
            $subCategory->save();
        }
        $subCategory->name = ['en' => $request->name_en, 'ar' => $request->name_ar];
        $subCategory->description = ['en' => $request->description_en, 'ar' => $request->description_ar];
        $subCategory->view_id = $request->view_id;
        $subCategory->text1 = ['en' => $request->text1_en, 'ar' => $request->text1_ar];
        $subCategory->text2 = ['en' => $request->text2_en, 'ar' => $request->text2_ar];
        $subCategory->text3 = ['en' => $request->text3_en, 'ar' => $request->text3_ar];
        $subCategory->update();
        $subCategory->subAccounts()->sync($request->sub_account);
        session()->flash('Add', 'تم التعديل سجل بنجاح ');
        return redirect()->back();
    }

    // all_sub_categories
    /**
     * @param $id
     */
    public function toggleAll($id)
    {
        $cat = Category::findOrFail($id);
        if ($cat->is_all) {
            $cat->is_all = 0;
            $cat->save();
        } else {
            $cat->is_all = 1;
            $cat->save();
        }
        return redirect()->back();
    }

    // save image in folder  in create image from dropzone
    /**
     * @param Request $request
     */
    public function categoriessaveImages(Request $request)
    {
        $file = $request->file('dzfile');
        $filename = uploadImageToS3('categories', $file);
        return response()->json([
            'name'          => $filename,
            'original_name' => $file->getClientOriginalName(),
        ]);
    }

    /**
     * @param  Request $request
     * @return int
     */
    public function sortable(Request $request)
    {
        if (count($request->order) > 0) {
            $position = Category::whereIn('id', $request->order)->min('position');

            // Update sort position
            foreach ($request->order as $id) {
                $product = Category::find($id);
                $product->position = $position;
                $product->update();

                $position++;
            }
            return 1;
        } else {
            return 0;
        }

        return response('Update Successfully.', 200);
    }

    //paginate ajaX ParentCategories

    /**
     * @param Request $request
     */
    public function fetch_data(Request $request)
    {
        if ($request->ajax()) {
            $sort_by = $request->get('sortby');
            $sort_type = $request->get('sorttype');
            $query = $request->get('query');
            $views = View::where('id', 'like', '%' . $query . '%')->get();
            $query = str_replace(" ", "%", $query);

            $categories = Category::where('parent_id', 0)->where('id', 'like', '%' . $query . '%')
                                                         ->Where('name', 'like', '%' . $query . '%')->
                orderBy($sort_by, $sort_type)->with('view')
                                                         ->paginate(10);

            $skipped = ($categories->currentPage() * $categories->perPage()) - $categories->perPage();

            $advertisment = Advertisment::where('category_id', 1)->first();
            if ($categories->count()) {
                $last_categories = Category::where('parent_id', '0')->latest()->first();
                $last_view = $last_categories->view()->first()->name;
            } else {
                $last_categories = '';
                $last_view = '';
            }
            return view('web.admin.categories.pagination_data', compact('categories', 'skipped', 'views', 'last_view', 'advertisment'))->render();
        }
    }
    //paginate ajaX subCategories
    /**
     * @param Request $request
     */
    public function fetch_data_subCategories(Request $request)
    {
        if ($request->ajax()) {
            $sort_by = $request->get('sortby');
            $sort_type = $request->get('sorttype');
            $query = $request->get('query');
            $views = View::where('id', 'like', '%' . $query . '%')->get();
            $query = str_replace(" ", "%", $query);
            $subCategories = Category::where('parent_id', $request->parent_id)
                ->where('id', 'like', '%' . $query . '%')

                ->orderBy($sort_by, $sort_type)->with('view')
                ->paginate(10);
            $skipped = ($subCategories->currentPage() * $subCategories->perPage()) - $subCategories->perPage();

            if ($subCategories->count()) {
                $last_categories = Category::where('parent_id', $request->parent_id)->latest()->first();
                $parent = Category::where('id', $subCategories->first()->parent_id)->first();
                $last_view = $last_categories->view()->first()->name;
            } else {
                $parent = '';
                $last_view = '';
            }

            $views = View::all();

            return view('web.admin.categories.subCategories.pagination_data', compact('subCategories', 'skipped', 'views', 'last_view', "parent"))->render();
        }
    }
    /**
     * @param Request $request
     */
    public function subCategoriesResult(Request $request)
    {
        if ($request->ajax()) {
            $sort_by = $request->get('sortby');
            $sort_type = $request->get('sorttype');
            $query = $request->get('query');
            $views = View::where('id', 'like', '%' . $query . '%')->get();
            $query = str_replace(" ", "%", $query);
            $subCategories = Category::where('parent_id', $request->parent_id)
                ->where('id', 'like', '%' . $query . '%')
                ->orderBy($sort_by, $sort_type)->with('view')
                ->paginate(10);
            $skipped = ($subCategories->currentPage() * $subCategories->perPage()) - $subCategories->perPage();
            if ($subCategories->count()) {
                $last_categories = Category::where('parent_id', $request->parent_id)->latest()->first();
                $parent = Category::where('id', $subCategories->first()->parent_id)->first();
                $last_view = $last_categories->view()->first()->name;
            } else {
                $parent = '';
                $last_view = '';
            }

            $views = View::all();

            return view('web.admin.categories.subCategories.pagination_data', compact('subCategories', 'skipped', 'views', 'last_view', "parent"))->render();
        }
    }

    ///search parent category
    /**
     * @param Request $request
     */
    public function serachParentCategory(Request $request)
    {
        $query = $request->input('query');
        $categories = Category::search($query)->where('parent_id', 0)->orderby('position')->with('view')->paginate(10);
        $skipped = ($categories->currentPage() * $categories->perPage()) - $categories->perPage();
        $advertisment = Advertisment::where('category_id', 1)->first();
        if ($categories->count()) {
            $last_categories = Category::where('parent_id', 0)->latest()->first();
            $last_view = $last_categories->view()->first()->name;
        } else {
            $last_categories = '';
            $last_view = '';
        }

        $views = View::all();

        return view('web.admin.categories.index', ['categories' => $categories, 'views' => $views, 'last_view' => $last_view, 'advertisment' => $advertisment, 'skipped' => $skipped]);
    }

    ///search sub category
    /**
     * @param Request $request
     */
    public function serachSubCategory(Request $request)
    {
        $query = $request->input('query');
        $subCategories = Category::search($query)->where('parent_id', $request->parent_id)->orderby('position')->paginate(10);
        $skipped = ($subCategories->currentPage() * $subCategories->perPage()) - $subCategories->perPage();

        if ($subCategories->count()) {
            $last_categories = Category::where('parent_id', $request->parent_id)->latest()->first();
            $parent = Category::where('id', $subCategories->first()->parent_id)->first();
            $last_view = $last_categories->view()->first()->name;
        } else {
            $parent = '';
            $last_view = '';
        }
        $views = View::all();
        return view('web.admin.categories.subCategories.search-results', ['subCategories' => $subCategories, 'views' => $views, 'parent' => $parent, 'last_view' => $last_view, 'skipped' => $skipped]);
    }
}
