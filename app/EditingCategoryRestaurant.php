<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EditingCategoryRestaurant extends Model
{
    protected $table = 'editing_category_restaurant';


    protected $fillable = [
        'category_id',
        'editing_restaurant_id',
        'name_ar',
        'name_en',
    ];


    public function editingRestaurant()
    {
        return $this->belongsTo('App\EditingRestaurant', 'editing_restaurant_id');
    }

    public function category()
    {
        return $this->belongsTo('App\RestaurantCategory', 'category_id');
    }
}
