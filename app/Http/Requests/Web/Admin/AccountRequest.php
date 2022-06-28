<?php

namespace App\Http\Requests\Web\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class AccountRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if (Request::isMethod('post')) {
            return [

                    'name'                   => 'required',

                ];
        } else {
            return [

                    'name'                       => 'required',


                ];
        }
    }


    public function messages()
    {
        return [
            'name.required'         => trans('lang.account_name_en_required'),
            // 'name_ar.required'           => trans('lang.account_unique')
        ];
    }
}
