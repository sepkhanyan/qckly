<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CollectionRequest extends FormRequest
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
        return   [
//            'name' => 'required|string|max:255',
//            'description' => 'required|text',
//            'service_provide' => 'required|text',
//            'service_presentation' => 'required|text',
//            'instructions' => 'required|string|max:255',
        ];


    }
}
