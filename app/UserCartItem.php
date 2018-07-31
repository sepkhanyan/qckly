<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCartItem extends Model
{
    protected $table = 'user_cart_items';


    protected $fillable = ['cart_id','collection_id', 'item_id', 'price', 'quantity', 'menu_id'];


    public function cart ()
    {
        return $this->belongsTo('App\UserCart', 'cart_id');
    }

    public function cartCollection ()
    {
        return $this->belongsTo('App\UserCartCollection', 'collection_id', 'collection_id');
    }


    public function menu ()
    {
        return $this->belongsTo('App\Menus', 'item_id');
    }

    public function category ()
    {
        return $this->belongsTo('App\Categories', 'menu_id');
    }
    public function collection ()
    {
        return $this->belongsTo('App\Collection', 'collection_id');
    }

}
