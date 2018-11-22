<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RestaurantArea extends Model
{
    protected $table = 'restaurant_area';

    protected $fillable = [
        'restaurant_id',
        'area_id',
        'name_en',
        'name_ar'
    ];



    public function restaurant()
    {
        return $this->belongsTo('App\Restaurant', 'restaurant_id');
    }

    public function area()
    {
        return $this->belongsTo('App\Area', 'area_id');
    }

}
