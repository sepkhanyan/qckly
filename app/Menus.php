<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menus extends Model
{
    protected $fillable = ['menu_name', 'menu_description', 'menu_price', 'menu_photo', 'menu_category_id', 'stock_qty', 'minimum_qty', 'subtract_stock', 'menu_status', 'menu_priority', 'mealtime_id'];


    protected $table = 'menus';


    protected $primaryKey = 'menu_id';

    public function restaurant()
    {
        return $this->hasMany('App\Locations', 'location_id', 'location_id');
    }
}
