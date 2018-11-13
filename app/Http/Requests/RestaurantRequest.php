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
//        $rules = [
//            'manager_name' => 'required|string|max:255',
//            'manager_email' => 'required|email|max:255',
//            'manager_username' => 'required|string|max:255',
//            'password' => 'required|string|min:6|confirmed',
//            'category' => 'required',
//            'restaurant_name_en' => 'required|string|max:255',
//            'restaurant_name_ar' => 'required|string|max:255',
//            'restaurant_email' => 'required|string|max:255',
//            'restaurant_telephone' => 'required|integer',
//            'description_en' => 'required|string',
//            'description_ar' => 'required|string',
//            'address_en' => 'required|string|max:255',
//            'address_ar' => 'required|string|max:255',
//            'postcode' => 'required|string|max:255',
//            'latitude' => 'required|numeric',
//            'longitude' => 'required|numeric',
//            'image' => 'required|image',
//            'daily_days' => 'required|array'
//
//        ];
//        if ($this->id) {
//            $rules = [
//                'restaurant_name_en' => 'required|string|max:255',
//                'restaurant_name_ar' => 'required|string|max:255',
//                'restaurant_email' => 'required|string|max:255',
//                'restaurant_telephone' => 'required|integer',
//                'description_en' => 'required|string',
//                'description_ar' => 'required|string',
//                'address_en' => 'required|string|max:255',
//                'address_ar' => 'required|string|max:255',
//                'postcode' => 'required|string|max:255',
//                'latitude' => 'required|numeric',
//                'longitude' => 'required|numeric',
//            ];
//        }
//        return $rules;


    }


    public function messages()
    {
//        return [
//            'email.email' => 'Please enter a valid email address',
//            'email.required' => 'Email address is required',
//            'password.required' => 'Password is required',
//        ];
    }
}
