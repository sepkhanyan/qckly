<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryRestaurant extends Model
{
    protected $table = 'category_restaurant';


    protected $fillable = [
        'category_id',
        'restaurant_id',
        'name_ar',
        'name_en',
    ];

    public function restaurant()
    {
        return $this->belongsTo('App\Restaurant', 'restaurant_id');
    }

    public function editingRestaurant()
    {
        return $this->belongsTo('App\EditingRestaurant', 'editing_restaurant_id');
    }

    public function category()
    {
        return $this->belongsTo('App\RestaurantCategory', 'category_id');
    }

    public function collection()
    {
        return $this->hasOne('App\Collection', 'service_type_id');
    }


}
