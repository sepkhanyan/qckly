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
    public function rules()
    {
        $rules =   [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|integer',
            'image' => 'required|image'

        ];
        if ($this->id) {
            $rules = [
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'category' => 'required|integer',
            ];
        }
        return $rules;


    }
}
