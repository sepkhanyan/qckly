<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    protected $fillable = ['restaurant_name', 'restaurant_email', 'description', 'restaurant_address_1', 'restaurant_address_2', 'restaurant_city', 'restaurant_state', 'restaurant_postcode', 'restaurant_country_id', 'restaurant_telephone', 'restaurant_lat', 'restaurant_lng',  'offer_delivery', 'offer_collection', 'delivery_time', 'last_order_time', 'reservation_interval', 'reservation_turn', 'collection_time', 'location_status', 'location_image', 'female_caterer_available',];


    protected $table = 'restaurants';



    public function collection()
    {
        return $this->hasMany('App\Collection', 'restaurant_id');
    }



    public function category()
    {
        return $this->belongsTo('App\RestaurantCategory', 'restaurant_category_id');
    }

    public function workingHour()
    {
        return $this->hasMany('App\WorkingHours', 'restaurant_id');
    }

    public function area()
    {
        return $this->belongsTo('App\Areas', 'restaurant_country_id');
    }

    public function menu()
    {
        return $this->hasMany('App\Menus', 'restaurant_id','id');
    }

    public function categoryRestaurant()
    {
        return $this->hasMany('App\CategoryRestaurant', 'restaurant_id');
    }
}
