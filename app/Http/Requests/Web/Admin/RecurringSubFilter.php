<?php

namespace App\Http\Requests\Web\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class RecurringSubFilter extends FormRequest
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

                    'name_en'                   => 'required',
                    'name_ar'                   => 'required',
        
                ];
        } else {
            return [

                    'name_en'                       => 'required',
                    'name_ar'                       => 'required',


                ];
        }
    }


    public function messages()
    {
        return [

            'name_en.required'                      => trans('lang.recurring_sub_filter_name_en_required'),
            'name_ar.required'                      => trans('lang.recurring_sub_filter_name_ar_required'),


        ];
    }
}
