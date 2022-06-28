<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CategoryType;
use App\Http\Requests\Web\Admin\CategoryTypeRequest;

class CategoryTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:category_types', ['only' => ['index']]);
        $this->middleware('permission:create_category_types', ['only' => ['create','store']]);
        $this->middleware('permission:update_category_types', ['only' => ['edit','update']]);
        $this->middleware('permission:delete_category_types', ['only' => ['destroy']]);
        
        $this->middleware('permission:recurring_category_category_types', ['only' => ['recurring_category.index','recurring_categories.index']]);
    }

    // to show all category_types
    public function index()
    {
        $category_types = CategoryType::paginate(50);
        return view('web.admin.category_types.index', compact('category_types'));
    }

    // to add an category_type
    public function store(CategoryTypeRequest $request)
    {
        $category_type = new CategoryType;
        $category_type->name = [ 'en' => $request->name_en, 'ar' => $request->name_ar];
        $category_type->save();

        session()->flash('Add', 'تم اضافة سجل بنجاح ');
        return redirect()->back();
    }

    // to update an category_type
    public function update(CategoryTypeRequest $request, $id)
    {
        $category_type = CategoryType::find($id);
        $category_type->name = [ 'en' => $request->name_en, 'ar' => $request->name_ar];
        $category_type->update();

        session()->flash('edit', 'تم تعديل السجل بنجاح ');
        return redirect()->back();
    }

 
    // to delete an category_type
    public function destroy($id)
    {
        $category_type = CategoryType::find($id);
        $category_type->delete();
        session()->flash('delete', 'تم حذف سجل بنجاح ');
        return redirect()->back();
    }
}
