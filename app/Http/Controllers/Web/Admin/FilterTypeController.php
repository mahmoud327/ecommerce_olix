<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FilterType;
use App\Http\Requests\Web\Admin\FilterTypeRequest;

class FilterTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:filter_types', ['only' => ['index']]);
        $this->middleware('permission:create_filter_types', ['only' => ['create','store']]);
        $this->middleware('permission:update_filter_types', ['only' => ['update','edit']]);
    }
    // to show all filter_types
    public function index()
    {
        $filter_types = FilterType::get();
        return view('web.admin.filter_types.index', compact('filter_types'));
    }

    // to add an filter_type
    public function store(FilterTypeRequest $request)
    {
        $filter_type = new FilterType;
        $filter_type->name = [ 'en' => $request->name_en, 'ar' => $request->name_ar];
        $filter_type->save();

        session()->flash('Add', 'تم اضافة سجل بنجاح ');
        return redirect()->back();
    }

    // to update an filter_type
    public function update(FilterTypeRequest $request, $id)
    {
        $filter_type = FilterType::find($id);
        $filter_type->name = [ 'en' => $request->name_en, 'ar' => $request->name_ar];
        $filter_type->update();

        session()->flash('edit', 'تم تعديل السجل بنجاح ');
        return redirect()->back();
    }

 
    // to delete an filter_type
    public function destroy($id)
    {
        $filter_type = FilterType::find($id);
        $filter_type->delete();
        session()->flash('delete', 'تم حذف سجل بنجاح ');
        return redirect()->back();
    }
}
