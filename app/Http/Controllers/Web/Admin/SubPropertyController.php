<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Requests\Web\Admin\SubPropertyRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductSubProperty;
use App\Models\SubProperty;

class SubPropertyController extends Controller
{

    // to show all a sub properties
    public function index($id)
    {
        $sub_properties = SubProperty::where('property_id', $id)->get();
        return view('web.admin.sub_properties.index', compact('sub_properties', 'id'));
    }

    // to create a sub property
    public function store(SubPropertyRequest $request)
    {
        $sub_property = new SubProperty;
        $sub_property->name = [ 'en' => $request->name_en, 'ar' => $request->name_ar];
        $sub_property->property_id = $request->property_id;
        $sub_property->save();

        session()->flash('Add', 'تم أضافة السجل بنجاح ');
        return redirect()->back();
    }

    // to edit a sub property
    public function update(SubPropertyRequest $request, $id)
    {
        $sub_property = SubProperty::findOrFail($id);
        $sub_property->name = [ 'en' => $request->name_en, 'ar' => $request->name_ar];
        $sub_property->update();
        session()->flash('edit', 'تم تعديل السجل بنجاح ');
        return redirect()->back();
    }

    // to delete a sub property
    public function destroy($id)
    {
        $sub_property = SubProperty::findOrFail($id);
        ProductSubProperty::where('sub_property_id', $sub_property->id)->delete();
        $sub_property->delete();
        session()->flash('delete', 'تم حذف السجل بنجاح ');
        return redirect()->back();
    }

    // to delete a sub property
    public function getSubProperties($id)
    {
        $sub_properties = SubProperty::where('property_id', $id)->get();
        return response($sub_properties);
    }
}
