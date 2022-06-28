<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Http\Requests\Web\Admin\ServiceRequest;

class ServiceController extends Controller
{
    // to show all organization_types
       
    // function __construct()
    // {

    //     $this->middleware('permission:organization_types', ['only' => ['index']]);

    //     $this->middleware('permission:create_organization_types', ['only' => ['create','store']]);
    //     $this->middleware('permission:update_organization_types', ['only' => ['edit','update']]);
    //     $this->middleware('permission:delete_organization_types', ['only' => ['destroy']]);
    //     $this->middleware('permission:delete_all_organization_types', ['only' => ['organization_types.delete_all']]);

    // }

    public function index()
    {
        $services = Service::get();
        return view('web.admin.services.index', compact('services'));
    }

    // to add an orgnization_type
    public function store(ServiceRequest $request)
    {
        $service = new Service;
        $service->name = [ 'en' => $request->name_en, 'ar' => $request->name_ar];
        $service->save();

        session()->flash('Add', 'تم اضافة سجل بنجاح ');
        return redirect()->back();
    }

    // to update an orgnization_type
    public function update(ServiceRequest $request, $id)
    {
        $service = Service::find($id);
        $service->name = [ 'en' => $request->name_en, 'ar' => $request->name_ar];

        $service->update();

        session()->flash('edit', 'تم تعديل السجل بنجاح ');
        return redirect()->back();
    }

 
    // to delete an orgnization_type
    public function destroy($id)
    {
        $service = Service::find($id);
        $service->delete();
        session()->flash('delete', 'تم حذف سجل بنجاح ');
        return redirect()->back();
    }

    public function delete_all(Request $request)
    {
        if ($request->delete_all_id) {
            $delete_all_id = explode(",", $request->delete_all_id);
    
            if (in_array('on', $delete_all_id)) {
                array_shift($delete_all_id);
            }

            Service::whereIn('id', $delete_all_id)->delete();
        }
        return back()->with('status', "Deleted successfully");
    }
}
