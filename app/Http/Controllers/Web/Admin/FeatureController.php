<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Feature;

class FeatureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $features = Feature::paginate(50);
        return view('web.admin.features.index', compact('features'));
    }




    public function store(Request $request)
    {
        $rules = [
            'name_ar' => 'required',
            'name_en' => 'required',

        ];

        $messages = [
            'name_ar.required' => 'feature arabic name required',
            'name_en.required' => 'feature english  name required',

        ];

        $this->validate($request, $rules, $messages);

        $features = new Feature;
       
        $features->name = ['en' => $request->name_en , 'ar' => $request->name_ar];
        $features->save();
        session()->flash('Add', 'تم اضافة سجل بنجاح ');
        return redirect()->back();
    }



    public function update(Request $request, $id)
    {
        $rules = [
            'name_ar' => 'required',
            'name_en' => 'required',

        ];

        $messages = [
            'name_ar.required' => 'feature arabic name required',
            'name_en.required' => 'feature english  name required',

        ];

        $this->validate($request, $rules, $messages);

        $features = Feature::find($id);
        $features->name = ['en' => $request->name_en , 'ar' => $request->name_ar];
        $features->update();
        session()->flash('edit', 'تم تعديل السجل بنجاح ');
        return redirect()->back();
    }


    public function destroy($id)
    {
        $account = Feature::find($id);
        $account->delete();
        session()->flash('delete', 'تم حذف سجل بنجاح ');
        return redirect()->back();
    }

    //multi_delete
    public function delete_all(Request $request)
    {
        $delete_all_id = explode(",", $request->delete_all_id);
        Feature::whereIn('id', $delete_all_id)->Delete();
 
         
        return back()->with('status', "Deleted successfully");
    }
}
