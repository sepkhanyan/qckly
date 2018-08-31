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

}
