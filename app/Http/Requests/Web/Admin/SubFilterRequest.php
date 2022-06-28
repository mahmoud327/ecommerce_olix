<?php

namespace App\Http\Requests\Web\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class SubFilterRequest extends FormRequest
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

                    'name_ar'         => 'required',
                    'name_en'         => 'required',
                    
                ];
        } else {
            return [

                    'name_ar'         => 'required',
                    'name_en'         => 'required',
                    
                ];
        }
    }


    public function messages()
    {
        return [

                'name_en.required'                      => trans('lang.sub_filter_name_en_required'),
                'name_ar.required'                      => trans('lang.sub_filter_name_ar_required'),


            ];
    }
}
