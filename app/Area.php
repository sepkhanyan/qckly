<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $table = 'areas';


    protected $fillable = [
        'name_en',
        'name_ar'
    ];


    public function restaurant()
    {
        return $this->hasMany('App\Restaurant', 'area_id');
    }

    public function restaurantArea()
    {
        return $this->hasMany('App\RestaurantArea', 'area_id');
    }

    public function editingRestaurantArea()
    {
        return $this->hasMany('App\EditingRestaurantArea', 'area_id');
    }

    public function cart()
    {
        return $this->hasMany('App\UserCart', 'delivery_order_area');
    }
}
