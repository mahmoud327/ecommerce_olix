<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Requests\Web\Admin\RecurringFilter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CategoryFilterRecurring;
use App\Models\CategoryRecurring;
use App\Models\FilterRecurring;
use App\Models\SubFilter;
use App\Models\Category;
use App\Models\Account;
use App\Models\Filter;
use App\Models\View;

class RecurringFilterController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:recurring_filters', ['only' => ['index']]);
        $this->middleware('permission:create_recurring_filter', ['only' => ['create','store']]);
        $this->middleware('permission:update_recurring_filter', ['only' => ['update','edit']]);
        $this->middleware('permission:delete_recurring_filter', ['only' => ['destroy','edit']]);
    }
    // to show all recurring filters
    public function index($id)
    {
        $recurring_filters = FilterRecurring::where('filter_type_id', $id)->orderby('position', 'asc')->get();

        // $cats_ids = Category::where('name', "NOT LIKE", '%For Sale%')->orWhere('name', "NOT LIKE", '%Wanted%')->pluck('id')->toArray();
        $cats_ids = Category::whereHas('parents', function ($q) {
            $q->where('name', "LIKE", '%New%');
        })->pluck('id')->toArray();
        $filters_ids = FilterRecurring::orderby('position', 'asc')->whereHas('categories', function ($q) use ($cats_ids) {
            $q->whereIn('category_filter_recurring.category_id', $cats_ids);
        })->pluck('id')->toArray();
        $filter_type_id = $id;
        return view('web.admin.recurring_filters.index', compact('recurring_filters', 'filter_type_id', 'filters_ids'));
    }

    // to show create recurring filter page
    public function create($id)
    {
        $parent_categories = Category::where('parent_id', 0)->get();
        $recurring_categories = CategoryRecurring::where('parent_id', 0)->get();

        // $re = CategoryRecurring::find(67);

        $re_ids = Category::whereIn('category_recurring_id', [65,64])->pluck('id')->toArray();


        $filter_type_id = $id;

        $last_level_id = View::where('name', 'last_level')->first()->id;

        return view('web.admin.recurring_filters.create', compact('parent_categories', 'recurring_categories', 'filter_type_id', 'last_level_id', 're_ids'));
    }


    // to create recurring filter
    public function store(RecurringFilter $request)
    {
        $count = FilterRecurring::where('filter_type_id', $request->filter_type_id)->max('position');
        $count = $count ? $count : 0;

        $recurring_filter = new FilterRecurring;
        $recurring_filter->name = [ 'en' => $request->name_en, 'ar' => $request->name_ar];
        $recurring_filter->filter_type_id = $request->filter_type_id;
        $recurring_filter->position = $count + 1;
        $recurring_filter->save();

        if ($request->has('document')) {
            $recurring_filter->image=$request->document;
            $recurring_filter->save();
        }


        if ($request->type_of_categories == 1) {
            $recurring_filter->categories()->attach($request->last_categories);
        } else {
            $categories_ids = Category::whereIn('category_recurring_id', $request->last_recurring_categories)->pluck('id');
            $recurring_filter->categories()->attach($categories_ids);
        }

        session()->flash('Add', 'تم أضافة السجل بنجاح ');
        return redirect(route('recurring_filter.index', $request->filter_type_id));
    }

    // to show edit recurring filter page
    public function edit($id)
    {

        // all values
        $parent_categories = Category::where('parent_id', 0)->get();
        $re_ids = Category::whereIn('category_recurring_id', [65,64])->pluck('id')->toArray();


        $recurring_categories = CategoryRecurring::where('parent_id', 0)->get();


        $last_level_id = View::where('name', 'last_level')->first()->id;

        // old selected values
        $recurring_filter = FilterRecurring::find($id);
        $categories_id = CategoryFilterRecurring::where('filter_recurring_id', $id)->pluck('category_id');
        $recurring_categories_id = Category::whereIn('id', $categories_id)->pluck('category_recurring_id');

        return view('web.admin.recurring_filters.edit', compact('categories_id', 'recurring_filter', 'parent_categories', 'recurring_categories', 'recurring_categories_id', 'last_level_id', 're_ids'));
    }

    // to update recurring filter
    public function update(RecurringFilter $request, $id)
    {
        $recurring_filter = FilterRecurring::find($id);
        $recurring_filter->name = [ 'en' => $request->name_en, 'ar' => $request->name_ar];
        $recurring_filter->update();


        if ($request->has('document')) {
            $image=$request->document;
            $recurring_filter->image=$image;
            $recurring_filter->save();
        }


        if ($request->type_of_categories == 1) {
            $recurring_filter->categories()->sync($request->last_categories);
        } else {
            $categories_ids = Category::whereIn('category_recurring_id', $request->last_recurring_categories)->pluck('id');
            $recurring_filter->categories()->sync($categories_ids);
        }

        session()->flash('edit', 'تم تعديل السجل بنجاح ');
        return redirect(route('recurring_filter.index', $recurring_filter->filter_type_id));
    }


    // to delete recurring filter
    public function destroy($id)
    {
        $recurring_filter = FilterRecurring::find($id);
        $recurring_filter->delete();

        session()->flash('delete', 'تم حذف السجل بنجاح ');
        return redirect()->back();
    }


    public function saveRecuringFilterImages(Request $request)
    {
        $file = $request->file('dzfile');
        $filename = uploadImageToS3('uploads/RecuringFilter', $file);

        return response()->json([
              'name' => $filename,
              'original_name' => $file->getClientOriginalName(),
          ]);
    }
    public function UpdateRecuringFilterImages(Request $request)
    {
        $file = $request->file('dzfile');
        $filename = uploadImageToS3('uploads/RecuringFilter', $file);


        return response()->json([
              'name' => $filename,
              'original_name' => $file->getClientOriginalName(),
          ]);
    }


    // to get all trashed recurring filters
    public function trash($filter_type_id)
    {
        $recurring_filters = FilterRecurring::onlyTrashed()->where('filter_type_id', $filter_type_id)->orderby('deleted_at')->paginate(200);
        return view('web.admin.recurring_filters.trash', compact('recurring_filters'));
    }

    // to restore a recurring filters
    public function restore($id)
    {
        $recurring_filter = FilterRecurring::onlyTrashed()->find($id);
        $recurring_filter->restore();

        return back()->with('status', "Recurring Filter has been restored successfully");
    }

    // to restore all recurring filters
    public function restoreAll(Request $request)
    {
        $restores_ids = explode(",", $request->restores_ids);
        $recurring_filters = FilterRecurring::onlyTrashed()->whereIn('id', $restores_ids)->get();

        foreach ($recurring_filters as $recurring_filter) {
            $recurring_filter->restore();
        }

        return back()->with('status', "Recurring Filter has been restored successfully");
    }


    // to force delete a recurring_filter
    public function forceDestroy($id)
    {
        $recurring_filter = FilterRecurring::onlyTrashed()->find($id);
        $recurring_filter->forceDelete();

        return back()->with('status', "Deleted successfully");
    }

    // to force delete all recurring_filters
    public function forceDestroyAll(Request $request)
    {
        $force_delete_all_ids = explode(",", $request->force_delete_all_id);
        $recurring_filters = FilterRecurring::onlyTrashed()->whereIn('id', $force_delete_all_ids)->get();

        foreach ($recurring_filters as $recurring_filter) {
            $recurring_filter->forceDelete();
        }

        return back()->with('status', "Deleted successfully");
    }



    // to sort the filters
    public function sortable(Request $request)
    {
        if (count($request->order) > 0) {
            $position = FilterRecurring::whereIn('id', $request->order)->min('position');

            // Update sort position
            foreach ($request->order as $id) {
                $product = FilterRecurring::find($id);
                $product->position = $position;
                $product->update();

                $position ++;
            }
            return 1;
        } else {
            return 0;
        }
    }
}
