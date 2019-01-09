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

    public function messages()
    {
        return [
            'manager_name.required' => 'The Name: field is required.',
            'manager_name.string' => 'The Manager Name: must be a string.',
            'manager_name.max'  => 'The Manager Name: may not be greater than 255 characters.',
            'manager_email.email' => 'The Email: must be a valid email address.',
            'manager_email.required' => 'The Email: field is required.',
            'manager_email.unique'     => 'The Email: has already been exists.',
            'manager_username.required' => 'The Username: field is required.',
            'manager_username.regex' => 'The Username: format is invalid.',
            'manager_telephone.required'  => 'The Telephone: field is required.',
            'manager_telephone.integer'   => 'The Telephone: must be an number.',
            'manager_telephone.unique'     => 'The Telephone: has already been exists.',
            'manager_telephone.digits'     => 'The Telephone: must be 8 digits.',
            'password.required'    =>  'The Password: field is required.',
            'password.min'     =>  'The Password: must be at least 6 characters.',
            'password.string'   =>  'The Password: must be a string.',
            'password.confirmed'   =>  'The Password: confirmation does not match.',
            'category.required'  => 'The Category: field is required.',
            'area.required'  => 'The City: field is required.',
            'restaurant_name_en.required' => 'The Name En: field is required.',
            'restaurant_name_en.string'  => 'The Name En: must be a string.',
            'restaurant_name_en.max'  => 'The Name En: may not be greater than 255 characters.',
            'restaurant_name_ar.required' => 'The Name Ar: field is required.',
            'restaurant_name_ar.string'  => 'The Name Ar: must be a string.',
            'restaurant_name_ar.max'  => 'The Name Ar: may not be greater than 255 characters.',
            'description_en.required' => 'The Description En: field is required.',
            'description_en.string'  => 'The Description En: must be a string.',
            'description_ar.required' => 'The Description Ar: field is required.',
            'description_ar.string'  => 'The Description Ar: must be a string.',
            'restaurant_email.email' => 'The Email: must be a valid email address.',
            'restaurant_email.required' => 'The Email: field is required.',
            'restaurant_email.unique'   => 'The Email: has already been exists.',
            'restaurant_telephone.required'  => 'The Telephone: field is required.',
            'restaurant_telephone.integer'   => 'The Telephone: must be an number.',
            'restaurant_telephone.unique'     => 'The Telephone: has already been exists.',
            'restaurant_telephone.digits'     => 'The Telephone: must be 8 digits.',
            'image.required' => 'The Image: field is required.',
            'image.mimes'  =>  'The image are not supported.',
            'image.max' =>  "The image may not be greater than 2 Mb.",
        ];
    }

    public function rules()
    {
        $rules = [
            'manager_name' => 'required|string|max:255',
            'manager_email' => 'required|email|unique:users,email|max:255',
            'manager_username' => 'required|regex:/^[\s\w-]*$/',
            'manager_telephone' => 'required|numeric|unique:users,mobile_number|digits:8',
            'password' => 'required|string|min:6|confirmed',
            'category' => 'required',
            'area' => 'required',
            'restaurant_name_en' => 'required|string|max:255',
            'restaurant_name_ar' => 'required|string|max:255',
            'restaurant_email' => 'required|email|unique:restaurants,email|max:255',
            'restaurant_telephone' => 'required|numeric|unique:restaurants,telephone|digits:8',
            'description_en' => 'required|string',
            'description_ar' => 'required|string',
            'image' => 'required|image|mimes:jpg,png,gif,bmp,jpeg,PNG,JPG,JPEG,GIF,BMP|max:2048'
        ];
        if ($this->opening_type == 'daily') {
            $rules['daily_days'] = 'required|array';
            $rules['daily_hours.open'] = 'required';
            $rules['daily_hours.close'] = 'required|after:daily_hours.open';
        }
        if ($this->opening_type == 'daily') {
            $rules['flexible_hours.1.open'] = 'required';
            $rules['flexible_hours.1.close'] = 'required|after:flexible_hours.1.open';
            $rules['flexible_hours.2.open'] = 'required';
            $rules['flexible_hours.2.close'] = 'required|after:flexible_hours.2.open';
            $rules['flexible_hours.3.open'] = 'required';
            $rules['flexible_hours.3.close'] = 'required|after:flexible_hours.3.open';
            $rules['flexible_hours.4.open'] = 'required';
            $rules['flexible_hours.4.close'] = 'required|after:flexible_hours.4.open';
            $rules['flexible_hours.5.open'] = 'required';
            $rules['flexible_hours.5.close'] = 'required|after:flexible_hours.5.open';
            $rules['flexible_hours.6.open'] = 'required';
            $rules['flexible_hours.6.close'] = 'required|after:flexible_hours.6.open';
            $rules['flexible_hours.0.open'] = 'required';
            $rules['flexible_hours.0.close'] = 'required|after:flexible_hours.0.open';
        }

        if ($this->id) {
            $rules = [
                'category' => 'required',
                'area' => 'required',
                'restaurant_name_en' => 'required|string|max:255',
                'restaurant_name_ar' => 'required|string|max:255',
                'restaurant_email' => 'required|email|max:255|unique:restaurants,email,' . $this->id,
                'restaurant_telephone' => 'required|numeric|digits:8|unique:restaurants,telephone,' . $this->id,
                'description_en' => 'required|string',
                'description_ar' => 'required|string',
                'image' => 'required|image|mimes:jpg,png,gif,bmp,jpeg,PNG,JPG,JPEG,GIF,BMP|max:2048'
            ];
        }
        return $rules;


    }
}
