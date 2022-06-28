<?php

namespace App\Http\Requests\Web\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class OraganizeRequest extends FormRequest
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
                "image"        => "sometimes|required",


            ];
    }


    public function messages()
    {
        return [
          'name_ar.required'           => trans('lang.organize_name_ar_required'),
          'name_en.required'           => trans('lang.organize_name_en_required'),
          'image.required'           => trans('lang.organize_image_required'),


      ];
    }
}
