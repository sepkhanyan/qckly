<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Locations extends Model
{
    protected $fillable = ['location_name', 'location_email', 'description', 'location_address_1', 'location_address_2', 'location_city', 'location_state', 'location_postcode', 'location_country_id', 'location_telephone', 'location_lat', 'location_lng', 'location_radius', 'covered_area', 'offer_delivery', 'offer_collection', 'delivery_time', 'last_order_time', 'delivery_charge', 'min_delivery_total', 'reservation_interval', 'reservation_turn', 'collection_time', 'location_status', 'options', 'location_image'];


    protected $table = 'locations';


    protected $primaryKey = 'location_id';

    public function area()
    {
        return $this->belongsTo('App\Areas', 'location_country_id');
    }

    public function menu()
    {
        return $this->belongsTo('App\Menus', 'location_id', 'location_id');
    }
}
