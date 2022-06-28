<?php

namespace App\Http\Requests\Web\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class ViewRequest extends FormRequest
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
                'name_en'      => 'required',
                'image'      => 'required',

            ];
        } else {
            return [
                'name_en'      => 'required',
            ];
        }
    }


    public function messages()
    {
        return [
            'name_en.required'         => 'view name is required',
            'name.unique'           => 'view name alredy exist',
            'image.required'           => 'view image is required'
        ];
    }
}
