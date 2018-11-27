<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EditingRestaurant extends Model
{
    protected $table = 'editing_restaurants';


    protected $fillable = [
        'name_en',
        'name_ar',
        'email',
        'description_en',
        'description_ar',
        'telephone',
        'status',
        'image',
    ];

    public function editingWorkingHour()
    {
        return $this->hasMany('App\EditingWorkingHour', 'editing_restaurant_id');
    }

    public function editingCategoryRestaurant()
    {
        return $this->hasMany('App\EditingCategoryRestaurant', 'editing_restaurant_id');
    }

    public function editingRestaurantArea()
    {
        return $this->hasMany('App\EditingRestaurantArea', 'editing_restaurant_id');
    }

    public function restaurant()
    {
        return $this->belongsTo('App\Restaurant', 'restaurant_id');
    }
}
