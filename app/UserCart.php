<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCart extends Model
{
    protected $table = 'user_carts';

    protected $fillable = ['user_id'];

    public function cartItem ()
    {
        return $this->hasMany('App\UserCartItem', 'cart_id');
    }

    public function collection ()
    {
        return $this->hasMany('App\Collection', 'collection_id');
    }

    public function item ()
    {
        return $this->hasMany('App\Menus', 'item_id');
    }
}
