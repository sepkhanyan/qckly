<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RestaurantCategory extends Model
{
    protected $table = 'restaurant_categories';


    protected $fillable = [
        'name_en',
        'name_ar'
    ];

    public function categoryRestaurant()
    {
        return $this->hasMany('App\CategoryRestaurant', 'category_id');
    }

    public function editingCategoryRestaurant()
    {
        return $this->hasMany('App\EditingCategoryRestaurant', 'category_id');
    }
}
