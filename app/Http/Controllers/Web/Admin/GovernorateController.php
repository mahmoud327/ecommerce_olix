<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Requests\Web\Admin\GovernorateRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Governorate;

class GovernorateController extends Controller
{

    // to show all a governorates
    public function index()
    {
        $governorates = Governorate::all();
        return view('web.admin.governorates.index', compact('governorates'));
    }

    // to create a governorate
    public function store(GovernorateRequest $request)
    {

        // return $request;

        $governorate = new Governorate;
        $governorate->name = [ 'en' => $request->name_en, 'ar' => $request->name_ar];
        $governorate->save();

        session()->flash('Add', 'تم أضافة السجل بنجاح ');
        return redirect()->back();
    }

    // to edit page
    public function edit($id)
    {
        $model = Governorate::findOrFail($id);

        return view('web.admin.governorates.edit', compact('model'));
    }

    // to edit a governorate
    public function update(Request $request, $id)
    {
        $governorate = Governorate::findOrFail($id);
        $governorate->name = [ 'en' => $request->name_en, 'ar' => $request->name_ar];
        $governorate->update();
        session()->flash('edit', 'تم تعديل السجل بنجاح ');
        return redirect()->back();
    }

    // to delete a governorate
    public function destroy($id)
    {
        $governorate = Governorate::findOrFail($id);
        $governorate->delete();
        session()->flash('delete', 'تم حذف السجل بنجاح ');
        return redirect()->back();
    }
}
