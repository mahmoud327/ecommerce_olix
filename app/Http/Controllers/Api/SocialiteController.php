<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;

use App\Models\SubAccountUser;
use App\Models\SubAccount;
use App\Models\Account;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Resources\UserResource;
use Validator;
use URL;
//use Str;
use Illuminate\Support\Str;

use Illuminate\Http\Request;

class SocialiteController extends BaseApiController
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    
    
    // Apple login
    public function redirectToApple()
    {
        return Socialite::driver('apple')->redirect();
    }

    // Apple callback
    public function handleAppleCallback()
    {
        $user = Socialite::driver('apple')->user();

        $this->_registerOrLoginUser($user);

        // Return home after login
        return redirect()->route('home');
    }

    // Google login
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Google callback
    public function handleGoogleCallback()
    {
        $user = Socialite::driver('google')->user();

        $this->_registerOrLoginUser($user);

        // Return home after login
        return redirect()->route('home');
    }

    // Facebook login
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    // Facebook callback
    public function handleFacebookCallback()
    {
        $user = Socialite::driver('facebook')->user();

        $this->_registerOrLoginUser($user);

        // Return home after login
        return redirect()->route('home');
    }

    // Github login
    public function redirectToGithub()
    {
        return Socialite::driver('github')->redirect();
    }

    // Github callback
    public function handleGithubCallback()
    {
        $user = Socialite::driver('github')->user();

        $this->_registerOrLoginUser($user);

        // Return home after login
        return redirect()->route('home');
    }

    protected function _registerOrLoginUser($data)
    {
        $user = User::where('email', '=', $data->email)->first();
        if (!$user) {
            $personal_sub_account = SubAccount::where('name', 'like', '%' . 'personal' . '%')->first();
            $user = new User();
            $user->name = $data->name;
            $user->email = $data->email;
            $user->iamge = $data->iamge;
            $user->provider_id = $data->id;
            $user->fcm_token    =  $data->fcm_token;

            
            $user->activate = 1;
            $user->verify_phone=1;

            $user->avatar = $data->avatar;
            $user->save();

            $userSubCcount = new SubAccountUser ;
            $userSubCcount->user_id	= $user->id ;
            $userSubCcount->sub_account_id	= $personal_sub_account->id ;
            $userSubCcount->save();
            
            $user->activate=  (integer)$user->activate;
            $user->verify_phone=  (integer)$user->verify_phone;

            $user->update();
        }

        Auth::login($user);
    }
    
    public function socialRegistration(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            // 'avatar' => 'required',
            'provider' => 'required',
            'provider_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendResponse([], 1, $validator->errors()->first());
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            $request->merge(['api_token' => Str::random(60)]);
            $user = User::create($request->all());
            $user->fcm_token =  $request->fcm_token;
            $user->activate=  (integer)$user->activate;
            $user->verify_phone=  (integer)$user->verify_phone;
            
            if ($request->has('image')) {
                $user->image = $request->image;
            }
            $user->update();
        }//end of if

        if ($request->has('image')) {
            $user->image =$request->image;
        }

        $user->activate=  (integer)$user->activate;
        $user->fcm_token    =  $request->fcm_token;

        $user->verify_phone=  (integer)$user->verify_phone;
        $user->update();

        $personal_sub_account = SubAccount::where('name', 'like', '%' . 'personal' . '%')->first();
        

        $userSubCcount = new SubAccountUser ;
        $userSubCcount->user_id	= $user->id ;
        $userSubCcount->sub_account_id	= $personal_sub_account->id ;
        $userSubCcount->save();


        return $this->sendResponse($user->makeHidden(['updated_at', 'created_at','organization_id','fcm_token','mobile_type','email_verified_at','provider_id','provider','api_token','avatar']), 'succses');
    }//end of social registerster



    public function socialAppleRegistration(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'          => 'required',
            'email'         => 'required',
            // 'avatar' => 'required',
            'provider'      => 'required',
            'provider_id'   => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendResponse([], 1, $validator->errors()->first());
        }

        $user = User::where('email', $request->email)
            ->first();
        if (!$user) {
            $request->merge(['api_token' => Str::random(60)]);
            $user = User::create($request->all());
            if ($request->has('image')) {
                $file = $request->image;
            
                $user->image =   $file ;
            }
            $user->fcm_token    =  $request->fcm_token;

            $user->activate =  (integer)$user->activate;
            $user->verify_phone=  (integer)$user->verify_phone;
            
            $user->update();
        }//end of if
        $user->image =$request->image;

        $user->activate     =  (integer)$user->activate;
        $user->fcm_token    =  $request->fcm_token;
        $user->verify_phone=  (integer)$user->verify_phone;
        $user->update();

        $personal_sub_account = SubAccount::where('name', 'like', '%' . 'personal' . '%')->first();
        

        $userSubCcount = new SubAccountUser ;
        $userSubCcount->user_id	= $user->id ;
        $userSubCcount->sub_account_id	= $personal_sub_account->id ;
        $userSubCcount->save();

        return $this->sendResponse($user->makeHidden(['updated_at', 'created_at','organization_id','fcm_token','mobile_type','email_verified_at','provider_id','provider','api_token','avatar']), 'succses');
    }//end of social registerster
}
