<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RestaurantRequest extends FormRequest
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
            'manager_name' => 'required|string|max:255',
            'manager_email' => 'required|string|max:255',
            'country_code' => 'required|string|max:255',
            'manager_telephone' => 'required|integer',
            'password' => 'required|string|min:6|confirmed',
            'category' => 'required|integer',
            'restaurant_name_en' => 'required|string|max:255',
            'restaurant_name_ar' => 'required|string|max:255',
            'restaurant_email' => 'required|integer',
            'restaurant_telephone' => 'required|integer',
            'description_en' => 'required|string',
            'description_ar' => 'required|string',
            'address_en' => 'required|string|max:255',
            'address_ar' => 'required|string|max:255',
            'city_en' => 'required|string|max:255',
            'city_ar' => 'required|string|max:255',
            'postcode' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'image' => 'required|image'

        ];
        if ($this->id) {
            $rules = [
                'category' => 'required|integer',
                'restaurant_name_en' => 'required|string|max:255',
                'restaurant_name_ar' => 'required|string|max:255',
                'restaurant_email' => 'required|integer',
                'restaurant_telephone' => 'required|integer',
                'description_en' => 'required|string',
                'description_ar' => 'required|string',
                'address_en' => 'required|string|max:255',
                'address_ar' => 'required|string|max:255',
                'city_en' => 'required|string|max:255',
                'city_ar' => 'required|string|max:255',
                'postcode' => 'required|string|max:255',
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
            ];
        }
        return $rules;


    }
}
