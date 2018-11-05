<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveryAddress extends Model
{
    protected $table = 'delivery_addresses';


    protected $fillable = [
        'address_id',
        'order_id',
        'name',
        'mobile_number',
        'location',
        'street_number',
        'building_number',
        'zone',
        'is_apartment',
        'apartment_number',
        'latitude',
        'longitude'
    ];

    public function address()
    {
        return $this->belongsTo('App\Address', 'address_id');
    }

    public function order()
    {
        return $this->belongsTo('App\Order', 'order_id');
    }
}
