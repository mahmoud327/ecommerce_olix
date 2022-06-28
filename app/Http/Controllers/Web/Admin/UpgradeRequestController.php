<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\SubAccountResource;
use Illuminate\Http\Request;
use App\Models\UpgradeRequest;
use App\Models\Organization;
use App\Models\SubAccount;

class UpgradeRequestController extends Controller
{
    // to show all upgrade requests
    public function __construct()
    {
        $this->middleware('permission:upgrade_requests', ['only' => ['upgrade_requests.index']]);
        $this->middleware('permission:upgrade_requests_show', ['only' => ['upgrade_requests.show']]);
        $this->middleware('permission:upgrade_requests_accepted', ['only' => ['upgrade_requests.accepted','upgrade_requests.rejected']]);
    }

    public function index()
    {
        $personal_id = SubAccount::where('name', 'like', '%' . 'personal' . '%')->first()->id;
        $upgrade_requests = UpgradeRequest::paginate(50);

        return view('web.admin.upgrade_requests.index', compact('upgrade_requests', 'personal_id'));
    }

    
    // to show details upgrade request
    public function show($id)
    {
        $personal_id = SubAccount::where('name', 'like', '%' . 'personal' . '%')->first()->id;
        $upgrade_request = UpgradeRequest::with('medias')->find($id);
        
        return view('web.admin.upgrade_requests.upgrade_request_details', compact('upgrade_request', 'personal_id'));
    }

    // to rejecte upgrade request
    public function rejected(Request $request, $id)
    {
        $upgrade_request = UpgradeRequest::find($id);
        $upgrade_request->rejected_reason = $request->rejected_reason;
        $upgrade_request->status='rejected';

        if ($upgrade_request->update()) {
            $notification = $upgrade_request->user->notifications()->create([

                    'title'     => ['en' => 'Upgrade reques has been rejected', 'ar' => 'تم رفض الطلب'],
                    'content'   => ['en' => $request->rejected_reason, 'ar' => $request->rejected_reason],

            ]);
            
            $tokens = $upgrade_request->user()->where('fcm_token', '!=', null)->pluck('fcm_token')->toArray();
            
            
            if (count($tokens)) {
                $title = $notification->getTranslation('title', $upgrade_request->user->lang);
                $body = $notification->getTranslation('content', $upgrade_request->user->lang);
                $send = notifyByFirebase($title, $body, $tokens, $data = null);
            }
        }

        return back()->with('status', 'rejected successfully.');
    }

    // to accept upgrade request
    public function acceptd(Request $request, $id)
    {
        $personal_id = SubAccount::where('name', 'like', '%' . 'personal' . '%')->first()->id;
        $upgrade_request = UpgradeRequest::find($id);
        $upgrade_request->status='accepted';
        

        if ($upgrade_request->update()) {
            if ($upgrade_request->user->subAccounts()) {
                $upgrade_request->user->subAccounts()->sync($request->sub_account);
            } else {
                $upgrade_request->user->subAccounts()->attach($request->sub_account);
            }
            
            if ($upgrade_request->organization_id == null) {
                $organization            = new Organization;
                $organization->name      = ['en' =>  $upgrade_request->organization_name , 'ar' =>$upgrade_request->organization_name];
                $organization->byadmin   =0;
                $organization->save();

                $upgrade_request->user->update(['organization_id' => $organization->id]);
            } else {
                $upgrade_request->user->update(['organization_id' => $upgrade_request->organization_id]);
            }
            
            $notification = $upgrade_request->user->notifications()->create([
                
                'title'     => ['en' => 'Upgrade request has been accepted', 'ar' => 'تم قبول الطلب'],
                'content'   => ['en' => 'You have been promoted after reviewing all the papers and documents sent by you, thanks.', 'ar' => 'لقد تم ترقيتك وذلك بعد الاطلاع علي كافة الاوراق والمستندات المرسلة من جهتك, وشكرا.'],
                
            ]);
            
            $tokens = $upgrade_request->user()->where('fcm_token', '!=', null)->pluck('fcm_token')->toArray();
            
            if (count($tokens)) {
                $title = $notification->getTranslation('title', $upgrade_request->user->lang);
                $body = $notification->getTranslation('content', $upgrade_request->user->lang);
                $data = [

                    "sub_accounts" => SubAccountResource::collection($upgrade_request->user->subAccounts()->where('sub_accounts.id', '!=', $personal_id)->get())
                ];
                $send = notifyByFirebase($title, $body, $tokens, $data);
            }
        }

        return back()->with('status', 'accepted successfully.');
    }
}
