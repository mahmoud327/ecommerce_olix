<?php

namespace App\Http\Requests\Web\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class CategoryRecurringRequest extends FormRequest
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
            
            'name_en'           => 'required',
            'name_ar'           => 'required',
            'sub_account'       => 'required',
            'categories_list'   => 'required',

        ];
        } else {
            return [

            'name_en'           => 'required',
            'name_ar'           => 'required',
            'sub_account'       => 'required',
            'categories_list'   => 'required',

        ];
        }
    }
   

    public function messages()
    {
        return [
            'name_en.required'         => 'يجب ادخال الاسم الانجليزي',
            'name_ar.required'         => 'يجب ادخال الاسم العربي',
            'sub_account.required'         => 'يجب ادخال نوع الحساب',
            'categories_list.required'         => 'يجب ادخال الفئة',
        ];
    }
}
