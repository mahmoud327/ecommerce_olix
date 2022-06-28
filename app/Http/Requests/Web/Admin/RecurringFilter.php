<?php

namespace App\Http\Requests\Web\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class RecurringFilter extends FormRequest
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
            if (Request::instance()->type_of_categories == "1") {
                return [

                    'name_en'           => 'required',
                    'name_ar'           => 'required',
                    'last_categories'   => 'required',
        
                ];
            } else {
                return [

                    'name_en'                       => 'required',
                    'name_ar'                       => 'required',
                    'last_recurring_categories'     => 'required',
        
                ];
            }
        } else {
            if (Request::instance()->type_of_categories == "1") {
                return [

                    'name_en'           => 'required',
                    'name_ar'           => 'required',
                    'last_categories'   => 'required',
        
                ];
            } else {
                return [

                    'name_en'                       => 'required',
                    'name_ar'                       => 'required',
                    'last_recurring_categories'     => 'required',
        
                ];
            }
        }
    }


    public function messages()
    {
        return [

            'name_en.required'                      => trans('lang.recurring_filter_name_en_required'),
            'name_ar.required'                      => trans('lang.recurring_filter_name_ar_required'),
            'last_categories.required'              => trans('lang.recurring_filter_last_categories_required'),
            'last_recurring_category.required'      => trans('lang.recurring_filter_last_recurring_category_required'),

        ];
    }
}
