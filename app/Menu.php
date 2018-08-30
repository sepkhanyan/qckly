<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = ['name', 'description', 'price', 'image', 'category_id', 'stock_qty', 'minimum_qty', 'subtract_stock', 'status', 'priority', 'mealtime', 'famous'];


    protected $table = 'menus';



    public function category()
    {
        return$this->belongsTo('App\Category','category_id' );
    }

    public function restaurant()
    {
        return $this->belongsTo('App\Restaurant', 'restaurant_id' );
    }

    public function collectionItem()
    {
        return $this->hasMany('App\CollectionItem', 'item_id');
    }

    public function cartItem ()
    {
        return $this->hasMany('App\UserCartItem', 'item_id');
    }
}
