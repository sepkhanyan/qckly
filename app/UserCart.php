<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCart extends Model
{
    protected $table = 'user_carts';

    protected $fillable = ['user_id', 'delivery_order_area', 'delivery_order_date', 'delivery_order_time'];

    public function cartItem ()
    {
        return $this->hasMany('App\UserCartItem', 'cart_id');
    }

    public function cartCollection()
    {
        return $this->hasMany('App\UserCartCollection', 'cart_id');
    }

    public function address()
    {
      return  $this->belongsTo('App\Address', 'delivery_address_id');
    }

}
