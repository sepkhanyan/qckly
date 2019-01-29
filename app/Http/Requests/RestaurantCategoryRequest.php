<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RestaurantCategoryRequest extends FormRequest
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

    public function messages()
    {
        return [
            'name_en.required' => 'The Name En: field is required.',
            'name_en.string'  => 'The Name En: must be a string.',
            'name_en.max'  => 'The Name En: may not be greater than 255 characters.',
            'name_ar.required' => 'The Name Ar: field is required.',
            'name_ar.string'  => 'The Name Ar: must be a string.',
            'name_ar.max'  => 'The Name Ar: may not be greater than 255 characters.',
        ];
    }

    public function rules()
    {
        return [
            'name_en' => 'required|string|max:255|unique:restaurant_categories,name_en',
            'name_ar' => 'required|string|max:255|unique:restaurant_categories,name_ar',
        ];
    }
}
