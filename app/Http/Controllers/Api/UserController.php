<?php

namespace App\Http\Controllers\Api;

use DB;
use Auth;
use Hash;
use App\Models\User;
use App\Models\Product;
use App\Models\SubAccount;
use App\Mail\ResetPassword;
use App\Models\MarketerCode;
use Illuminate\Http\Request;
use App\Models\SubAccountUser;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Storage;

class UserController extends BaseApiController
{
    /**
     * @param  Request $request
     * @param  $user
     * @return mixed
     */
    public function register(Request $request, $user = null)
    {
        $validator = validator()->make($request->all(), [
            'name'        => 'required',
            'mobile'      => 'required',
            'password'    => 'required|min:8',
            'mobile_type' => 'required|in:android,ios',
            'fcm_token'   => 'required',

        ]);

        if ($validator->fails()) {
            return sendJsonError($validator->errors()->first(), '409');
        }

        $mobile = convert2english($request->mobile);

        // return $mobile;

        $user = User::where('mobile', $mobile)->first();
        $lang = $request->header('x-localization');

        $string = $lang == 'ar' ? " الرقم مسجل بالفعل يرجى تسجيل الدخول" : "Mobile already exist please login ";

        $users_phones = User::pluck('mobile')->toarray();
        if (!$user) {
            $personal_sub_account = SubAccount::where('name', 'personal')->first();
            if (in_array($mobile, $users_phones)) {
                return sendJsonError($string);
            }

            $user = new User();
            $user->name = $request->name;
            $user->password = Hash::make($request->password);
            $user->image = 'uploads/users/avatar.png';
            $user->mobile = $mobile;
            $user->mobile_type = $request->mobile_type;
            $user->fcm_token = $request->fcm_token;
            $user->verify_phone = 0;
            // $user->organization_id = 1 ;
            $user->save();

            $userSubCcount = new SubAccountUser;
            $userSubCcount->user_id = $user->id;
            $userSubCcount->sub_account_id = $personal_sub_account->id;
            $userSubCcount->save();

            $code = rand(1111, 9999);
            $update = $user->update(['pin_code' => $code]);
            $user->sendOtpNotification($code);

            $user->activate = (integer) $user->activate;
            $user->verify_phone = (integer) $user->verify_phone;

            $user->update();

            if ($user->update()) {
                $phone = $mobile;
                $products = Product::where('phone', 'LIKE', "%{$phone}%")->where('byadmin', 1);
                $products->update(['user_id' => $user->id, 'verify_phone' => 1]);
            }

            return $this->sendResponse(new UserResource($user), 'users', 200);
        } else {
            if (in_array($mobile, $users_phones)) {
                return sendJsonError($string);
            }

            if ($user->verify_phone == 1) {
                $user->activate = (integer) $user->activate;
                $user->verify_phone = (integer) $user->verify_phone;
                $user->update();

                return sendJsonError($string);
            } else {
                $code = rand(1111, 9999);
                $update = $user->update(['pin_code' => $code]);

                $user->sendOtpNotification($code);

                $user->activate = (integer) $user->activate;
                $user->verify_phone = (integer) $user->verify_phone;
                $user->update();
                $user->makeHidden(['updated_at', 'created_at', 'organization_id', 'fcm_token', 'mobile_type', 'email_verified_at', 'pin_code']);

                return $this->sendResponse(new UserResource($user), $string, 200);
            }
        }
    }
    /**
     * @param  Request $request
     * @return mixed
     */
    public function login(Request $request)
    {
        $validator = validator()->make($request->all(), [

            'mobile_type' => 'required|in:android,ios',
            'mobile'      => 'required',

        ]);

        if ($validator->fails()) {
            return sendJsonError($validator->errors()->first(), '409');
        }

        $lang = $request->header('x-localization');

        $mobile = convert2english($request->mobile);

        $user = User::where('mobile', $mobile)->first();
        if ($user) {
            if ($user->activate == 1) {
                if (!auth()->attempt((['mobile' => request('mobile'), 'password' => request('password')]))) {
                    $string = $lang == 'ar' ? "من فضلك تأكد من كلمة المرور" : "Please check your password";
                    return sendJsonError($string, 403);
                } else {
                    $accessToken = $user->createToken('authToken')->accessToken;
                    $user->fcm_token = $request->fcm_token;
                    $user->mobile_type = $request->mobile_type;
                    $user->activate = (integer) 1;
                    $user->verify_phone = (integer) $user->verify_phone;
                    $user->update();
                    return $this->sendResponse(new UserResource($user), 'succses', 200);
                }
            } else {
                if (!auth()->attempt((['mobile' => request('mobile'), 'password' => request('password')]))) {
                    $string = $lang == 'ar' ? "من فضلك تأكد من كلمة المرور" : "Please check your password";

                    return sendJsonError($string, 403);
                }

                $code = rand(1111, 9999);
                $update = $user->update(['pin_code' => $code]);
                $user->sendOtpNotification($code);
                $user->activate = (integer) $user->activate;
                $user->verify_phone = (integer) $user->verify_phone;
                $user->update();
                return $this->sendResponse(new UserResource($user), 'user dont activate and is sent bin_code in mobile', 200);
            }
        } else {
            $string = $lang == 'ar' ? "من فضلك تأكد من الهاتف " : "Please check your phone Number";
            return sendJsonError($string);
        }
    }

    ////////////////////////////// start profile

    /**
     * @param  Request $request
     * @return mixed
     */
    public function profile(Request $request)
    {
        $lang = $request->header('x-localization');
        $string_update = $lang == 'ar' ? "تم تعديل البيانات " : "updated successfully";

        $user = \Auth::guard('api')->user();

        $users_phones = User::pluck('mobile')->toarray();

        if ($request->hasFile('image')) {
            Storage::disk('s3')->delete('uploads/users/' . $user->image);

            $file_name = $request->file('image')->store('uploads/users', 's3');
            Storage::disk('s3')->setVisibility($file_name, 'public');
            $user->image = $file_name;

            $user->save();
        }

        if ($request->name) {
            $user->name = $request->name;
            $user->save();
        }

        if ($request->marketer_code) {
            $code = MarketerCode::where('code', $request->marketer_code)->first();

            if ($code) {
                $user->update(['marketer_code_id' => $code->id]);
            } else {
                return sendJsonError('code doesnot exist');
            }
        }

        if ($request->mobile) {
            $mobile = convert2english($request->mobile);

            $validator = validator()->make($request->all(), [

                'mobile' => 'unique:users,mobile,' . $user->id,

            ]);

            if ($validator->fails()) {
                return sendJsonError('phone has been token');
                // return sendJsonError('Please make sure that the data entered is correct','409');
            }

            if ($user->mobile == $mobile) {
                $user->mobile = $mobile;
                $user->verify_phone = (integer) 1;
                $user->save();
                return $this->sendResponse(new UserResource($user), $string_update, 200);
            } else {
                $code = rand(1111, 9999);
                $update = $user->update(['pin_code' => $code]);
                $user->mobile = $mobile;
                $user->save();
                $user->sendOtpNotification($code);
                $user->verify_phone = (integer) 0;
                $user->save();
                return $this->sendResponse(new UserResource($user), 'sent code sucessfully', 200);
            }
        }

        return $this->sendResponse(new UserResource($user), $string_update, 200);
    }

    ////////////////////////////// end profile ///////////////
    ////////////////////////////// start profile ///////////////

    /**
     * @param  Request $request
     * @return mixed
     */
    public function update_password(Request $request)
    {
        $lang = $request->header('x-localization');

        if (Auth::guard('api')->check()) {
            $validator = validator()->make($request->all(), [

                'old_password' => 'required',
                'password'     => 'required|confirmed',
            ]);

            if ($validator->fails()) {
                return sendJsonError($validator->errors()->first(), 200);
            }

            $user = \Auth::guard('api')->user();

            if (Hash::check($request->input('old_password'), $user->password)) {
                $user->password = bcrypt($request->input('password'));
                $user->save();
                $string_update = $lang == 'ar' ? "تم تعديل البيانات " : "updated successfully";

                return $this->sendResponse($string_update, 200);
            } else {
                $string = $lang == 'ar' ? "من فضلك تأكد من كلمة المرور" : "Please check your password";
                return sendJsonError($string);
            }
        } else {
            return sendJsonError('must be Auth');
        }
    }

    ////////////////////////////// end profile ///////////////

    /**
     * @param Request $request
     */
    public function resetPassword(Request $request)
    {
        $lang = $request->header('x-localization');

        $validator = validator()->make($request->all(), [

            'mobile' => 'required',

        ]);

        if ($validator->fails()) {
            return sendJsonError($validator->errors()->first(), 200);
        }
        $mobile = convert2english($request->mobile);
        $user = User::where('mobile', $mobile)->first();

        if ($user) {
            $code = rand(1111, 9999);
            $user->sendOtpNotification($code);
            $user->pin_code = $code;
            $user->save();

            return sendJsonResponse('Success', ' successfully sent code.');
        } else {
            return sendJsonError('the account dont exist');
        }
    }

    /**
     * @param  Request $request
     * @return mixed
     */
    public function verify_code(Request $request)
    {
        $lang = $request->header('x-localization');
        $string_update = $lang == 'ar' ? "تم تسجيل بنجاح " : "updated successfully";

        $validator = validator()->make($request->all(), [

            'pin_code' => 'required',

        ]);

        if ($validator->fails()) {
            return sendJsonError($validator->errors()->first(), 200);
        }

        $user = User::where('mobile', $request->mobile)->where('pin_code', $request->pin_code)->first();

        if ($user) {
            $user->activate = 1;
            $user->verify_phone = 1;
            $user->save();
            $user->makeHidden(['updated_at', 'created_at', 'provider_id', 'provider', 'organization_id', 'fcm_token', 'mobile_type', 'email_verified_at', 'pin_code']);

            if ($request->mobile) {
                $mobile = convert2english($request->mobile);

                $user->mobile = $mobile;
                $user->verify_phone = (integer) 1;

                if ($user->save()) {
                    $phone = $mobile;
                    $products = Product::where('phone', 'LIKE', "%{$phone}%")->where('byadmin', 1);
                    $products->update(['user_id' => $user->id, 'verify_phone' => 1]);
                }
            }

            return $this->sendResponse($user, $string_update, 200);
        } else {
            $string = $lang == 'ar' ? "من فضلك تأكد من الكود " : "Please check your code";

            return sendJsonError($string);
        }
    }

    ////////////////////////////// end resetPassword ///////////////

    /**
     * @param Request $request
     */
    public function newPassword(Request $request)
    {
        $lang = $request->header('x-localization');

        $validator = validator()->make($request->all(), [

            'mobile'   => 'required',
            'password' => 'required|confirmed',

        ]);

        if ($validator->fails()) {
            return sendJsonError($validator->errors()->first(), 200);
        }

        $mobile = convert2english($request->mobile);
        $user = User::where('mobile', $mobile)->first();

        if ($user) {
            $user->password = bcrypt($request->password);
            $user->update();

            if ($user->save()) {
                $string_update = $lang == 'ar' ? "تم تعديل البيانات " : "updated successfully";

                return sendJsonResponse('Success', $string_update);
            } else {
                return sendJsonError('happen error');
            }
        } else {
            $string = $lang == 'ar' ? "من فضلك تأكد من الهاتف " : "Please check your phone";

            return sendJsonError($string);
        }
    }

    ////////////////////////////// end newPassword ///////////////
    public function logout()
    {
        $user = Auth::user();
        $user->fcm_token = null;
        $user->save();
        $accessToken = Auth::user()->token();
        DB::table('oauth_refresh_tokens')
            ->where('access_token_id', $accessToken->id)
            ->update([
                'revoked' => true,
            ]);

        $accessToken->revoke();
        return sendJsonResponse('Success', 'deleted successfully.');
    }

    /**
     * @param Request $request
     */
    public function reSendCode(Request $request)
    {
        $lang = $request->header('x-localization');

        $validator = validator()->make($request->all(), [

            'phone' => 'required',

        ]);

        if ($validator->fails()) {
            return sendJsonError($validator->errors()->first(), 200);
        }

        $mobile = convert2english($request->phone);
        $user = User::where('mobile', $mobile)->first();

        $code = rand(1111, 9999);

        if ($user) {
            $user->update(['pin_code' => $code]);
            $user->sendOtpNotification($code);
            return sendJsonResponse('Success', 'the new code has been sent successfully.');
        } else {
            $string = $lang == 'ar' ? "الحساب غير موجود" : 'account doest exist';
            return sendJsonError($string);
        }
    }

    /**
     * @param  Request $request
     * @return mixed
     */
    public function setMarketerCode(Request $request)
    {
        $lang = $request->header('x-localization');

        $validator = validator()->make($request->all(), [

            'marketer_code' => 'required|exists:marketer_codes,code',

        ]);

        if ($validator->fails()) {
            return sendJsonError($validator->errors()->first(), 200);
        }

        $user = auth()->guard('api')->user();

        $code = MarketerCode::where('code', $request->marketer_code)->first();

        if ($user->marketer_code_id == null) {
            $user->update(['marketer_code_id' => $code->id, 'points' => 1000]);
            $string = $lang == 'ar' ? ".مبروك, لقد حصلت علي 1000 نقطة" : 'Congratulation you got 1000 points.';
            return $this->sendResponse(new UserResource($user), $string, 200);
        } else {
            $user->update(['marketer_code_id' => $code->id]);
            $string = $lang == 'ar' ? ".نأسف, انت بالفعل حصلت علي 1000 نقطة من قبل" : 'Sorry, you already got 1000 points befor.';
            return $this->sendResponse(new UserResource($user), $string, 200);
        }
    }
}
