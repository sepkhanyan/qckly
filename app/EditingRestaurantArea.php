<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EditingRestaurantArea extends Model
{
    protected $table = 'editing_restaurant_area';

    protected $fillable = [
        'area_id',
        'name_en',
        'name_ar',
        'editing_restaurant_id'
    ];



    public function editingRestaurant()
    {
        return $this->belongsTo('App\EditingRestaurant', 'editing_restaurant_id');
    }

    public function area()
    {
        return $this->belongsTo('App\Area', 'area_id');
    }
}
