<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MenuRequest extends FormRequest
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
            'category.required'  => 'The Category: field is required.',
            'category.integer'  => 'The Category: must be an integer.',
            'name_en.required' => 'The Name En: field is required.',
            'name_en.string'  => 'The Name En: must be a string.',
            'name_en.max'  => 'The Name En: may not be greater than 255 characters.',
            'name_ar.required' => 'The Name Ar: field is required.',
            'name_ar.string'  => 'The Name Ar: must be a string.',
            'name_ar.max'  => 'The Name Ar: may not be greater than 255 characters.',
            'description_en.required' => 'The Description En: field is required.',
            'description_en.string'  => 'The Description En: must be a string.',
            'description_ar.required' => 'The Description Ar: field is required.',
            'description_ar.string'  => 'The Description Ar: must be a string.',
            'price.required'  => 'The Price: field is required.',
            'price.numeric'  => 'The Price: must be a number.',
            'price.min'  => 'The Price: must be at least 0.',
            'image.required' => 'The Image: field is required.',
            'image.mimes'    =>  'The image are not supported.',
            'image.max'      =>  "The image may not be greater than 2 Mb."
        ];
    }

    public function rules()
    {
        $rules = [
            'name_en' => 'required|string|max:255',
            'description_en' => 'required|string',
            'name_ar' => 'required|string|max:255',
            'description_ar' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|integer',
            'image' => 'required|image|mimes:jpg,png,gif,bmp,jpeg,PNG,JPG,JPEG,GIF,BMP|max:2048'

        ];
        if ($this->id) {
            $rules = [
                'name_en' => 'string|max:255',
                'description_en' => 'string',
                'name_ar' => 'string|max:255',
                'description_ar' => 'string',
                'price' => 'numeric|min:0'
            ];
            if($this->hasFile('image')){
                $rules['image'] = 'image|mimes:jpg,png,gif,bmp,jpeg,PNG,JPG,JPEG,GIF,BMP|max:2048';
            }
        }
        return $rules;


    }
}
