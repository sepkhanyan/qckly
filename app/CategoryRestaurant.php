<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryRestaurant extends Model
{
    protected $table = 'category_restaurant';



    protected $fillable = ['category_id', 'restaurant_id', 'category_name_ar', 'category_name_en'];

    public function restaurant()
    {
        return $this->belongsTo('App\Restaurant', 'restaurant_id');
    }

}
