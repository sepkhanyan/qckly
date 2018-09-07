<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class CategoryRequest extends FormRequest
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
        $rules =   [
            'name_en' => 'required|string|max:255',
            'description_en' => 'required|string',
            'name_ar' => 'required|string|max:255',
            'description_ar' => 'required|string',
            'image' => 'required|string'
        ];
        if ($this->id) {
            $rules = [
                'name_en' => 'required|string|max:255',
                'description_en' => 'required|string',
                'name_ar' => 'required|string|max:255',
                'description_ar' => 'required|string',
            ];
        }
        return $rules;

    }
}
