<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    protected $table = 'restaurants';


    protected $fillable = [
        'name_en',
        'name_ar',
        'email',
        'description_en',
        'description_ar',
//        'address_en',
//        'address_ar',
//        'state_en',
//        'state_ar',
//        'postcode',
//        'area_id',
        'telephone',
//        'latitude',
//        'longitude',
        'status',
        'image',
        'active'
    ];


    public function editingRestaurant()
    {
        return $this->hasOne('App\EditingRestaurant', 'restaurant_id');
    }

    public function collection()
    {
        return $this->hasMany('App\Collection', 'restaurant_id');
    }
    public function orderCollection()
    {
        return $this->hasMany('App\OrderCollection', 'restaurant_id');
    }


    public function cartCollection()
    {
        return $this->hasMany('App\UserCartCollection', 'restaurant_id');
    }

    public function category()
    {
        return $this->belongsTo('App\RestaurantCategory', 'category_id');
    }

    public function workingHour()
    {
        return $this->hasMany('App\WorkingHour', 'restaurant_id');
    }

    public function area()
    {
        return $this->belongsTo('App\Area', 'area_id');
    }

    public function restaurantArea()
    {
        return $this->hasMany('App\RestaurantArea', 'restaurant_id');
    }

    public function menuCategory()
    {
        return $this->hasMany('App\MenuCategory', 'restaurant_id');
    }

    public function menu()
    {
        return $this->hasMany('App\Menu', 'restaurant_id');
    }

    public function categoryRestaurant()
    {
        return $this->hasMany('App\CategoryRestaurant', 'restaurant_id');
    }

    public function review()
    {
        return $this->hasMany('App\Review', 'restaurant_id');
    }

    public function user()
    {
        return $this->hasOne('App\User', 'restaurant_id');
    }

    public function orderRestaurant()
    {
        return $this->hasMany('App\OrderRestaurant', 'restaurant_id');
    }
}
