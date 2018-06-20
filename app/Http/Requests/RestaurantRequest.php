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
        return   [
            /*'location_name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'telephone' => 'required|string|max:255',
            'address[address_1]' => '|string|max:255',
            'address[city]' => 'string|max:255',
            'address[postcode]' => 'string|max:255',
            'address[country]' => 'string|max:255',
            'address[location_lat]' => 'float',
            'address[location_lng]' => 'float',
            'description' => 'required|string|max:255',
            'delivery_time' => 'required|integer',
            'collection_time' => 'required|integer',
            'last_order_time' => 'required|integer',
            'reservation_time_interval' => 'required|integer',
            'reservation_stay_time' => 'required|integer',*/



        ];


    }
}
