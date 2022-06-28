<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubAccountUser;
use App\Models\SubAccount;
use App\Models\Product;
use App\Models\Account;
use App\Models\User;
use DB;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:users', ['only' => ['index']]);
        $this->middleware('permission:user_activate', ['only' => ['user.activate','user.deactivate']]);
        $this->middleware('permission:user_activate', ['only' => ['user_upgrade']]);
        $this->middleware('permission:delete_all_user', ['only' => ['users.delete_all']]);
        $this->middleware('permission:delete_user', ['only' => ['destroy']]);
    }

    // to show all users
    public function index()
    {
        $personal_id = SubAccount::where('name', 'like', '%' . 'personal' . '%')->first()->id;
        $user_sub_account =SubAccountUser::latest()->first();
        $users_count=User::count();

        $data = User::with(['subAccounts','products'])->paginate(50);
        $skipped = ($data->currentPage() * $data->perPage()) - $data->perPage();


        return view('web.admin.users.index', compact('data', 'user_sub_account', 'personal_id', 'users_count', 'skipped'));
    }

    // to show all products of user
    public function productOfUser($id)
    {
        $products = Product::where('user_id', $id)->get();
        
        return view('web.admin.users.products', compact('products'));
    }


    // to update an account
    public function update(Request $request, $id)
    {
        $user=User::find($id);
        if ($user->subAccounts) {
            $user->subAccounts()->sync($request->sub_account);
        } else {
            $user->subAccounts()->attach($request->sub_account);
        }
        return redirect(route('users.index'));
    }

 
    // to delete an account
    public function destroy($id)
    {
        $user = User::find($id);

        $token = $user->where('fcm_token', $user->fcm_token)->pluck('fcm_token')->toArray();

        $notification = $user->notifications()->create([

            'content'     => ['en' => 'Your account is currently suspended', 'ar' => 'تم وقفك حاليا'],
            'title'   => ['en' => 'Suiiz Support', 'ar' =>' suiiz فريق الدعم لدى '],

         ]);
    
        if (count($token)) {
            $title = $notification->getTranslation('title', $user->lang);
            $body = $notification->getTranslation('content', $user->lang);
            $send = notifyByFirebase($title, $body, $token, $data = null);
        }

        if ($user->products()->exists()) {
            $user->products()->delete();
        }
        $user->delete();

        return redirect(route('users.index'))->with('delete', "تم حذف سجل بنجاح");
    }


    // to show sub accounts of account

    // approve post
    public function active($id)
    {
        $user= User::find($id);
        if ($user) {
            $user->activate=1;
            $user->save();
            return redirect(route('users.index'));
        }
    }

    
    public function deactivate($id)
    {
        $user= User::find($id);
        if ($user) {
            $user->activate=0;
            $user->save();

            return redirect(route('users.index'));
        }
    }

    // search for product


    public function delete_all(Request $request)
    {
        $delete_all_id = explode(",", $request->delete_all_id);
        User::whereIn('id', $delete_all_id)->Delete();

        return back()->with('status', "Deleted successfully");
    }


    public function search(Request $request)
    {
        $query = $request->input('query');
        $users = User::search($query)->orderBy('id', 'DESC')->paginate(50);
        $skipped = ($users->currentPage() * $users->perPage()) - $users->perPage();

        return view('web.admin.users.search-results', compact('users', 'skipped'));
    }


    public function fetch_data(Request $request)
    {
        if ($request->ajax()) {
            $sort_by = $request->get('sortby');
            $sort_type = $request->get('sorttype');
            $query = $request->get('query');
            $query = str_replace(" ", "%", $query);
            $data = user::where('id', 'like', '%'.$query.'%')
                    ->orWhere('name', 'like', '%'.$query.'%')
                    ->orWhere('email', 'like', '%'.$query.'%')
                    ->orWhere('mobile', 'like', '%'.$query.'%')
                    ->orderBy($sort_by, $sort_type)->with('products')
                    ->paginate(50);
            $skipped = ($data->currentPage() * $data->perPage()) - $data->perPage();

            return view('web.admin.users.pagination_data', compact('data', 'skipped'))->render();
        }
    }

    public function sendNotification(Request $request, $user_id)
    {
        $user=User::find($user_id);
     
        $token = $user->where('fcm_token', $user->fcm_token)->pluck('fcm_token')->toArray();

        $notification = $user->notifications()->create([

        'content'     => ['en' => $request->content_en, 'ar' =>  $request->content_ar],
        'title'   => ['en' =>  $request->title_en, 'ar' => $request->title_en],

     ]);

    

        if (count($token)) {
            $title = $notification->getTranslation('title', $user->lang);

            $body = $notification->getTranslation('content', $user->lang);

            $send = notifyByFirebase($title, $body, $token, $data = ["suiiz" =>"suiiz"]);
        }
        return back()->with('status', "send notification successfully");
    }
    public function sendNotificationAllUser(Request $request)
    {
        $users=User::get();
        $tokens = $users->pluck('fcm_token')->toArray();
        $notification = $users->notifications()->create([

        'content'     => ['en' => $request->content_en, 'ar' =>  $request->content_ar],
        'title'   => ['en' =>  $request->title_en, 'ar' => $request->title_en],

     ]);

    

        if (count($tokens)) {
            $title = $notification->getTranslation('title', $users->first()->lang);

            $body = $notification->getTranslation('content', $users->first()->lang);

            $send = notifyByFirebase($title, $body, $tokens, $data = ["suiiz" =>"suiiz"]);
        }
        return back()->with('status', "send notification successfully");
    }
}
