<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Requests\Web\Admin\RecurringSubFilter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubFilterRecurring;
use App\Models\SubFilter;

class RecurringSubFilterController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:recurring_sub_filters', ['only' => ['recurring_sub_filters','index']]);
        $this->middleware('permission:create_recurring_sub_filters', ['only' => ['create','store']]);
        $this->middleware('permission:update_recurring_sub_filters', ['only' => ['update','edit']]);
        $this->middleware('permission:delete_recurring_sub_filters', ['only' => ['destroy']]);
    }

    // to show all recurring sub filters page
    public function subFilters($id)
    {
        $recurring_sub_filters = SubFilterRecurring::where('filter_recurring_id', $id)->orderby('position', 'asc')->get();
        $recurring_filter_id = $id;
        return view('web.admin.recurring_sub_filters.index', compact('recurring_sub_filters', 'recurring_filter_id'));
    }



    // to create recurring sub filter
    public function store(RecurringSubFilter $request)
    {
        $count = SubFilterRecurring::where('filter_recurring_id', $request->recurring_filter_id)->max('position');
        $count = $count ? $count : 0;

        $recurring_sub_filter = new SubFilterRecurring;
        $recurring_sub_filter->name = [ 'en' => $request->name_en, 'ar' => $request->name_ar];
        $recurring_sub_filter->filter_recurring_id = $request->recurring_filter_id;
        $recurring_sub_filter->position = $count + 1;

        $recurring_sub_filter->save();


        if ($request->has('document')) {
            $recurring_sub_filter->image = $request->document;
            $recurring_sub_filter->save();
        }


        session()->flash('Add', 'تم أضافة السجل بنجاح ');
        return redirect()->back();
    }

    public function edit($id)
    {
        $recurring_sub_filter=SubFilterRecurring::find($id);
        return view('web.admin.recurring_sub_filters.edit', compact('recurring_sub_filter'));
    }

    // to update recurring sub filter
    public function update(RecurringSubFilter $request, $id)
    {
        $recurring_sub_filter = SubFilterRecurring::find($id);
        $recurring_sub_filter->name = [ 'en' => $request->name_en, 'ar' => $request->name_ar];
        $recurring_sub_filter->update();

        if ($request->has('document')) {
            $recurring_sub_filter->image=$request->document;
            $recurring_sub_filter->save();
        }

        session()->flash('edit', 'تم تعديل السجل بنجاح ');
        return redirect()->back();
    }


    // to delete recurring sub filter
    public function destroy($id)
    {
        $recurring_sub_filter = SubFilterRecurring::find($id);
        $recurring_sub_filter->delete();

        session()->flash('delete', 'تم حذف السجل بنجاح ');
        return redirect()->back();
    }

    public function saveRecuringSubFilterImages(Request $request)
    {
        $file = $request->file('dzfile');
        $filename = uploadImageToS3('uploads/RecuringSubFilter', $file);

        return response()->json([
              'name' => $filename,
              'original_name' => $file->getClientOriginalName(),
          ]);
    }


    // to get all trashed recurring sub filters
    public function trash($filter_recurring_id)
    {
        $recurring_sub_filters = SubFilterRecurring::onlyTrashed()->where('filter_recurring_id', $filter_recurring_id)->orderby('deleted_at')->paginate(200);
        return view('web.admin.recurring_sub_filters.trash', compact('recurring_sub_filters'));
    }

    // to restore a recurring sub filters
    public function restore($id)
    {
        $recurring_sub_filter = SubFilterRecurring::onlyTrashed()->find($id);
        $recurring_sub_filter->restore();

        return back()->with('status', "Recurring Sub Filter has been restored successfully");
    }

    // to restore all recurring sub filters
    public function restoreAll(Request $request)
    {
        $restores_ids = explode(",", $request->restores_ids);
        $recurring_sub_filters = SubFilterRecurring::onlyTrashed()->whereIn('id', $restores_ids)->get();

        foreach ($recurring_sub_filters as $recurring_sub_filter) {
            $recurring_sub_filter->restore();
        }

        return back()->with('status', "Recurring Sub Filter has been restored successfully");
    }


    // to force delete a recurring_sub_filter
    public function forceDestroy($id)
    {
        $recurring_sub_filter = SubFilterRecurring::onlyTrashed()->find($id);
        $recurring_sub_filter->forceDelete();

        return back()->with('status', "Deleted successfully");
    }

    // to force delete all recurring_sub_filters
    public function forceDestroyAll(Request $request)
    {
        $force_delete_all_ids = explode(",", $request->force_delete_all_id);
        $recurring_sub_filters = SubFilterRecurring::onlyTrashed()->whereIn('id', $force_delete_all_ids)->get();

        foreach ($recurring_sub_filters as $recurring_sub_filter) {
            $recurring_sub_filter->forceDelete();
        }

        return back()->with('status', "Deleted successfully");
    }


    // to sort the sub filters
    public function sortable(Request $request)
    {
        if (count($request->order) > 0) {
            $position = SubFilterRecurring::whereIn('id', $request->order)->min('position');
            // return $position;

            // Update sort position
            foreach ($request->order as $id) {
                $product = SubFilterRecurring::find($id);
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
