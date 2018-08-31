<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCartItem extends Model
{
    protected $table = 'user_cart_items';


    protected $fillable = [
        'cart_id',
        'collection_id',
        'item_id',
        'price',
        'quantity',
        'menu_id'
    ];



    public function cartCollection ()
    {
        return $this->belongsTo('App\UserCartCollection', 'cart_collection_id');
    }


    public function menu ()
    {
        return $this->belongsTo('App\Menu', 'item_id');
    }


    public function category ()
    {
        return $this->belongsTo('App\Category', 'menu_id');
    }


    public function collection ()
    {
        return $this->belongsTo('App\Collection', 'collection_id');
    }

}
