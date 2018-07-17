<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCartItem extends Model
{
    protected $table = 'user_cart_items';


    protected $fillable = ['collection_id', 'item_id', 'price', 'quantity'];


    public function cart ()
    {
        return $this->belongsTo('App\UserCart', 'cart_id');
    }
}
