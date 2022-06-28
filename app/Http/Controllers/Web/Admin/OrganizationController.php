<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Organization;
use App\Models\Media;
use App\Traits\mediaTrait;
use App\Http\Requests\Web\Admin\OraganizeRequest;
use Illuminate\Support\Facades\Storage;

class OrganizationController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:organizations', ['only' => ['organization.index']]);
        $this->middleware('permission:create_organization', ['only' => ['organization.create','store']]);
        $this->middleware('permission:update_organization', ['only' => ['edit','update']]);
        $this->middleware('permission:delete_organization', ['only' => ['destroy']]);
        $this->middleware('permission:posts', ['only' => ['post_organization']]);
        $this->middleware('permission:delete_all_organization', ['only' => ['organizations.delete_all']]);
        $this->middleware('permission:organizations_mobile', ['only' => ['organizations_mobile']]);
    }

    use mediaTrait;

    public function index($id)
    {
        $organizations = Organization::where('organization_type_id', $id)->where('byadmin', 1)->paginate(100);
        $organization_type_id = $id;
        return view('web.admin.organizations.index', compact('organizations', 'organization_type_id'));
    }
    public function organizations_mobile()
    {
        $organizations_mobile = Organization::where('byadmin', 0)->paginate(100);

        return view('web.admin.organizations.organizations_mobile', compact('organizations_mobile'));
    }


    public function store(Request $request)
    {
        $organization =new Organization();

        $organization->name    =     ['en' => $request->name_en , 'ar' => $request->name_ar];
        $organization->phones                =       $request->phones;
        $organization->description          =       $request->description;
        $organization->organization_type_id          =       $request->organization_type_id;
        $organization->byadmin          =      1;
        $organization->save();


        if ($request->hasFile('background_cover')) {
            $file_name = $request->file('background_cover')->store('uploads/organiztions', 's3');
            Storage::disk('s3')->setVisibility($file_name, 'public');
            $organization->update(['background_cover' => $file_name]);
        }
        if ($request->hasFile('image')) {
            $file_name = $request->file('image')->store('uploads/organiztions', 's3');
            Storage::disk('s3')->setVisibility($file_name, 'public');


            $organization->media()->create([

                'url'  => $file_name,
                'path' => $file_name,
                'full_file' =>'http://' .\Request::getHost() .$file_name,

            ]);
        }


        return back()->with('status', 'Added successfully.');
    }

    public function update(Request $request, $id)
    {
        $organization = Organization::findorfail($id);




        if ($request->hasFile('image')) {
            $organization->media ? $path = $organization->media()->first()->path : $path = null;
            Storage::disk('s3')->delete($path);

            $file_name = $request->file('image')->store('uploads/organiztions', 's3');
            Storage::disk('s3')->setVisibility($file_name, 'public');

            $organization->media()->update([

            'url'   =>  $file_name,
            'path'  =>  $file_name,
            'full_file'=>'http://' .\Request::getHost() .''.$file_name	,

          ]);
        }


        if ($request->hasFile('background_cover')) {
            Storage::disk('s3')->delete($organization->background_cover);


            $file_name = $request->file('background_cover')->store('uploads/organiztions', 's3');
            Storage::disk('s3')->setVisibility($file_name, 'public');
            $organization->background_cover = $file_name;
            $organization->update();
        }

        if ($request->phones) {
            $organization->link=$request->link;
            $organization->name    =     ['en' => $request->name_en , 'ar' => $request->name_ar];
            $organization->phones=$request->phones;
            $organization->description=$request->description;
            $organization->save();
        } else {
            $organization->phones= $organization->phones;
            $organization->link=$request->link;
            $organization->name    =     ['en' => $request->name_en , 'ar' => $request->name_ar];
            $organization->description=$request->description;
            $organization->save();
        }



        return back()->with('status', '  Updated successfully.');
    }



    public function destroy($id)
    {
        $organization = Organization::findorfail($id);
        $organization->delete();

        return back()->with('status', "Deleted successfully");
    }
    // multi_delete
    public function delete_all(Request $request)
    {
        $delete_all_id = explode(",", $request->delete_all_id);

        Organization::whereIn('id', $delete_all_id)->Delete();

        return back()->with('status', "Deleted successfully");
    }

    // to get all trashed organizations
    public function trash()
    {
        $organizations = Organization::onlyTrashed()->orderby('deleted_at')->paginate(200);
        return view('web.admin.organizations.trash', compact('organizations'));
    }

    // to restore a organization
    public function restore($id)
    {
        $organization = Organization::onlyTrashed()->find($id);
        $organization->restore();

        return back()->with('status', "Organization has been restored successfully");
    }

    // to restore all organizations
    public function restoreAll(Request $request)
    {
        $restores_ids = explode(",", $request->restores_ids);

        $organizations = Organization::onlyTrashed()->whereIn('id', $restores_ids)->get();

        foreach ($organizations as $organization) {
            $organization->restore();
        }

        return back()->with('status', "Categories has been restored successfully");
    }


    // to force delete a organization
    public function forceDestroy($id)
    {
        $organization = Organization::onlyTrashed()->find($id);

        \Storage::disk('s3')->delete($organization->background_cover);
        \Storage::disk('s3')->delete($organization->media->path);
        $organization->media()->forceDelete();
        $organization->forceDelete();

        return back()->with('status', "Deleted successfully");
    }

    // to force delete all organizations
    public function forceDestroyAll(Request $request)
    {
        $force_delete_all_ids = explode(",", $request->force_delete_all_id);
        $organizations = Organization::onlyTrashed()->whereIn('id', $force_delete_all_ids)->get();

        foreach ($organizations as $organization) {
            \Storage::disk('s3')->delete($organization->background_cover);
            $medias = Media::whereIn('mediaable_id', $force_delete_all_ids)->get();



            if (count($medias) >  0) {
                foreach ($medias as $media) {
                    \Storage::disk('s3')->delete($media->path);
                    $media->forceDelete();
                }
            }


            $organization->forceDelete();
        }

        return back()->with('status', "Deleted successfully");
    }
}
