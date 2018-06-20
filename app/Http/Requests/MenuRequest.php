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
        return   [
            'menu_name' => 'required|string|max:255',
            'menu_description' => 'required|string',
            'menu_category' => 'required|integer',
            'stock_qty' => 'required|integer',
            'minimum_qty' => 'required|integer',
            'menu_priority' => 'required|integer',

        ];


    }
}
