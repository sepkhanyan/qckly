<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    protected $table = 'restaurants';


    protected $fillable = [
        'name',
        'email',
        'description',
        'address',
        'city',
        'state',
        'postcode',
        'area_id',
        'telephone',
        'latitude',
        'longitude',
        'status',
        'image',
        'user_id'
    ];



    public function collection()
    {
        return $this->hasMany('App\Collection', 'restaurant_id');
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
        return $this->belongsTo('App\User', 'user_id');
    }
}
