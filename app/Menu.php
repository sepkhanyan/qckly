<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menus';


    protected $fillable = [
        'name_en',
        'description_en',
        'name_ar',
        'description_ar',
        'price',
        'image',
        'category_id',
        'status',
        'famous'
    ];



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
