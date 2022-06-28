<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrganizationService;
use App\Models\Category;
use App\Models\CategoryRecurring;
use App\Models\View;
use App\Models\City;
use App\Models\Service;
use App\Models\OrganizationServiceService;
use App\Models\CategoryOrganizationService;

use Illuminate\Support\Facades\Storage;

use App\Http\Requests\Web\Admin\OrganizationServiceRequest;

class OrganizationServiceController extends Controller
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
        $organization_services = OrganizationService::orderby('position')->get();

        return view('web.admin.organization_services.index', compact('organization_services'));
    }


    public function create()
    {
        $re_ids = Category::whereIn('category_recurring_id', [65,64])->pluck('id')->toArray();
        $recurring_categories = CategoryRecurring::where('parent_id', 0)->get();
        $last_level_id = View::where('name', 'last_level')->first()->id;
        $parent_categories = Category::where('parent_id', 0)->get();
        $re = CategoryRecurring::find(67);

        return view('web.admin.organization_services.create', compact('parent_categories', 'last_level_id', 're_ids', 'recurring_categories'));
    }



    // to add an orgnization_type
    public function store(OrganizationServiceRequest $request)
    {
        $count = OrganizationService::max('position');

        if ($request->city_id=="select cities") {
            $request->city_id=null;
        }

        $Organization_service                       =       new OrganizationService;
        $Organization_service->name                 =       [ 'en' => $request->name_en, 'ar' => $request->name_ar];
        $Organization_service->phones               =       $request->phones;
        $Organization_service->links                =       $request->links;
        $Organization_service->description          =       $request->description;
        $Organization_service->google_map_link      =       $request->google_map_link;
        $Organization_service->position             =       $count + 1;
        $Organization_service->city_name            =       $request->city_name;
        $Organization_service->city_id              =       $request->city_id;
        $Organization_service->save();



        if ($request->hasFile('image')) {
            $file_name = $request->file('image')->store('uploads/organizationService', 's3');
            Storage::disk('s3')->setVisibility($file_name, 'public');
            $Organization_service->image = $file_name;
            $Organization_service->save();
        }

        if (!$request->services_id) {
            for ($i = 0; $i < count($request->services_id) ; $i++) {
                OrganizationServiceService::create([

              'organization_service_id'    => $Organization_service->id,
              'service_id'               => $request->services_id[$i],
              'price'                     => $request->price[$i]

            ]);
            }
        }

        if ($request->type_of_categories == 1) {
            $Organization_service->categories()->attach($request->last_categories);
        } else {
            $categories_ids = Category::whereIn('category_recurring_id', $request->last_recurring_categories)->pluck('id');
           
            $Organization_service->categories()->attach($categories_ids);
        }

        session()->flash('Add', 'تم أضافة السجل بنجاح ');

        return redirect(route('organization_services.index'));
    }

    
    public function edit($id)
    {
        $organization_service = OrganizationService::find($id);

        $parent_categories = Category::where('parent_id', 0)->get();
        $re_ids = Category::whereIn('category_recurring_id', [65,64])->pluck('id')->toArray();

        $recurring_categories = CategoryRecurring::where('parent_id', 0)->get();

        $last_level_id = View::where('name', 'last_level')->first()->id;

      
        $organization_services = OrganizationServiceService::where('organization_service_id', $organization_service->id)->get();

        $services=Service::get();

        $categories_id = CategoryOrganizationService::where('organization_service_id', $id)->pluck('category_id');
        $recurring_categories_id = Category::whereIn('id', $categories_id)->pluck('category_recurring_id');

        return view('web.admin.organization_services.edit', compact('organization_service', 'categories_id', 'parent_categories', 're_ids', 'last_level_id', 'organization_services', 'services', 'recurring_categories', 'recurring_categories_id'));
    }

  
    // to update an orgnization_type
    public function update(OrganizationServiceRequest $request, $id)
    {
        $organization_service = OrganizationService::find($id);
        
        $organization_service->name             =          ['en' => $request->name_en , 'ar' => $request->name_ar];
        $organization_service->phones           =         $request->phones;
        $organization_service->description      =         $request->description;
        $organization_service->links            =         $request->links;
        $organization_service->city_name        =          $request->city_name;
        $organization_service->google_map_link  =          $request->google_map_link;
        $organization_service->city_id              =       $request->city_id;



        $organization_service->save();

        if ($request->hasFile('image')) {
            $file_name = $request->file('image')->store('uploads/organizationService', 's3');
            Storage::disk('s3')->setVisibility($file_name, 'public');
            Storage::disk('s3')->delete($organization_service->image);
            $organization_service->image = $file_name;
            $organization_service->update();
        }


        $organization_services=   OrganizationServiceService::where('organization_service_id', $organization_service->id)->delete();


        if ($request->has('services_id')) {
            for ($i = 0; $i < count($request->services_id) ; $i++) {
                OrganizationServiceService::create([
    
                    'organization_service_id'    => $organization_service->id,
                    'service_id'               => $request->services_id[$i],
                    'price'                     => $request->price[$i]
    
                ]);
            }
        }
        
        if ($request->type_of_categories == 1) {
            $organization_service->categories()->sync($request->last_categories);
        } else {
            $categories_ids = Category::whereIn('category_recurring_id', $request->last_recurring_categories)->pluck('id');
            $organization_service->categories()->sync($categories_ids);
        }


        session()->flash('edit', 'تم تعديل السجل بنجاح ');
        return redirect(route('organization_services.index'));
    }

 
    // to sort the products
    public function sortable(Request $request)
    {
        if (count($request->order) > 0) {
            $position = OrganizationService::whereIn('id', $request->order)->min('position');

            // Update sort position
            foreach ($request->order as $id) {
                $Organization_service = OrganizationService::find($id);
                $Organization_service->position = $position;
                $Organization_service->update();

                $position ++;
            }
            return 1;
        } else {
            return 0;
        }
    }


    // to delete an orgnization_type
    public function destroy($id)
    {
        $organization_service = OrganizationService::find($id);
        $organizations=OrganizationServiceService::where('organization_service_id', $id)->delete();
        $organization_service->categories()->detach();
        $organization_service->delete();
    
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
            OrganizationServiceService::whereIN('organization_service_id', $delete_all_id)->delete();
            CategoryOrganizationService::whereIN('organization_service_id', $delete_all_id)->delete();
            OrganizationService::whereIn('id', $delete_all_id)->delete();
        }
    
        return back()->with('status', "Deleted successfully");
    }
}
