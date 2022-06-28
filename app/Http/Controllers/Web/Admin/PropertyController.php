<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Requests\Web\Admin\PropertyRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductSubProperty;
use App\Models\SubProperty;
use App\Models\Property;

class PropertyController extends Controller
{

    // to show all a properties
    public function index()
    {
        $properties = Property::all();
        return view('web.admin.properties.index', compact('properties'));
    }

    // to create a property
    public function store(PropertyRequest $request)
    {
        $property = new Property;
        $property->name = [ 'en' => $request->name_en, 'ar' => $request->name_ar];
        $property->save();

        session()->flash('Add', 'تم أضافة السجل بنجاح ');
        return redirect()->back();
    }

    // to edit page
    public function edit($id)
    {
        $model = Property::findOrFail($id);

        return view('web.admin.properties.edit', compact('model'));
    }

    // to edit a property
    public function update(PropertyRequest $request, $id)
    {
        $property = Property::findOrFail($id);
        $property->name = [ 'en' => $request->name_en, 'ar' => $request->name_ar];
        $property->update();
        session()->flash('edit', 'تم تعديل السجل بنجاح ');
        return redirect()->back();
    }

    // to delete a property
    public function destroy($id)
    {
        $property = Property::findOrFail($id);
        $sub_property_ids = $property->subProperties()->pluck('id')->toArray();
        ProductSubProperty::whereIn('sub_property_id', $sub_property_ids)->delete();
        $property->subProperties()->delete();
        $property->delete();
        session()->flash('delete', 'تم حذف السجل بنجاح ');
        return redirect()->back();
    }
}
