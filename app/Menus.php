<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menus extends Model
{
    protected $fillable = ['menu_name', 'menu_description', 'menu_price', 'menu_photo', 'menu_category_id', 'stock_qty', 'minimum_qty', 'subtract_stock', 'menu_status', 'menu_priority', 'mealtime_id', 'famous'];


    protected $table = 'menus';


    protected $primaryKey = 'menu_id';

    public function category()
    {
        return$this->hasOne('App\Categories', 'category_id','menu_category_id' );
    }

    public function restaurant()
    {
        return $this->hasOne('App\Restaurant', 'restaurant_id', 'restaurant_id');
    }
}
