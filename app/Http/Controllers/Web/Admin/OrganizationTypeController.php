<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrganizationType;
use App\Http\Requests\Web\Admin\OrganizationTypeRequest;

class OrganizationTypeController extends Controller
{
    // to show all organization_types
       
    public function __construct()
    {
        $this->middleware('permission:organization_types', ['only' => ['index']]);

        $this->middleware('permission:create_organization_types', ['only' => ['create','store']]);
        $this->middleware('permission:update_organization_types', ['only' => ['edit','update']]);
        $this->middleware('permission:delete_organization_types', ['only' => ['destroy']]);
        $this->middleware('permission:delete_all_organization_types', ['only' => ['organization_types.delete_all']]);
    }

    public function index()
    {
        $organization_types = OrganizationType::paginate(50);
        return view('web.admin.organization_types.index', compact('organization_types'));
    }

    // to add an orgnization_type
    public function store(OrganizationTypeRequest $request)
    {
        $orgnization_type = new OrganizationType;
        $orgnization_type->name = [ 'en' => $request->name_en, 'ar' => $request->name_ar];
        $orgnization_type->save();

        session()->flash('Add', 'تم اضافة سجل بنجاح ');
        return redirect()->back();
    }

    // to update an orgnization_type
    public function update(OrganizationTypeRequest $request, $id)
    {
        $orgnization_type = OrganizationType::find($id);
        $orgnization_type->name = [ 'en' => $request->name_en, 'ar' => $request->name_ar];
        $orgnization_type->update();

        session()->flash('edit', 'تم تعديل السجل بنجاح ');
        return redirect()->back();
    }

 
    // to delete an orgnization_type
    public function destroy($id)
    {
        $orgnization_type = OrganizationType::find($id);
        $orgnization_type->delete();
        session()->flash('delete', 'تم حذف سجل بنجاح ');
        return redirect()->back();
    }
}
