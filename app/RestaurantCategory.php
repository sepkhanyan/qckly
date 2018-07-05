<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RestaurantCategory extends Model
{
    protected $table = 'restaurant_categories';


    protected $fillable = ['restaurant_category_name_en', 'restaurant_category_name_ar'];

    public function restaurant()
    {
        return $this->hasMany('App\Restaurant', 'restaurant_category_id');
    }
}
