<?php

namespace App\Http\Requests\Web\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class OrganizationServiceRequest extends FormRequest
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
                    
                    'name_en'           => 'required',
                    'name_ar'           => 'required',
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

            'name_en.required'                      =>'name english is required' ,
            'name_ar.required'                      => 'name arabic is required',
            'last_categories.required'              => 'category is required',
            'last_recurring_category.required'      =>'recurring_category is required' ,

        ];
    }
}
