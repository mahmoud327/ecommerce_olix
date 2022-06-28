<?php

namespace App\Http\Requests\Web\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class ProductRequest extends FormRequest
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
        return [
                'name_ar'          => 'required',
                'name_en'          => 'required',
                 'city_id'      => 'required',
                // 'last_categories'      => 'required',

                // 'discount'         => 'required',
                // 'link'             => 'required',
                // 'phone'            => 'required',
                'contact'          => 'required',
                // 'description_ar'   => 'required',
                // 'description_en'   => 'required',
                // 'note_en'          => 'required',
                // 'note_ar'          => 'required',
                // 'quantity'         =>'required|numeric',
                "document"        => "sometimes|required",


            ];
    }


    public function messages()
    {
        return [

            'name_en'                    => 'required',
            'name_ar'                    => 'required',
            'city_id.required'           => 'you have to select city',
            'last_categories.required'   => trans('lang.last_categories_required'),
            'contact.required'           => trans('lang.contact_required'),
            'document.required'          => trans('lang.document_required'),

      ];
    }
}
