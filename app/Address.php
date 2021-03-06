<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'addresses';


    protected $fillable = [
        'user_id',
        'name',
        'mobile_number',
        'location',
        'street_number',
        'building_number',
        'zone',
        'is_apartment',
        'apartment_number',
        'latitude',
        'longitude',
        'deleted'
    ];


    public function user()
    {
        return $this->hasMany('App\User', 'user_id');
    }

    public function cart()
    {
        return $this->hasMany('App\UserCart', 'delivery_address_id');
    }

    public function deliveryAddress()
    {
        return $this->hasOne('App\DeliveryAddress', 'address_id');
    }
}
