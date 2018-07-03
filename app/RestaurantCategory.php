<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RestaurantCategory extends Model
{
    protected $table = 'restaurant_categories';

    protected $primaryKey = 'restaurant_category_id';

    protected $fillable = ['restaurant_category_name_en', 'restaurant_category_name_ar'];

    public function restaurant()
    {
        return $this->belongsTo('App\Restaurant', 'restaurant_category_id','restaurant_category_id');
    }
}
