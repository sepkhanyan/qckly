<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCartCollection extends Model
{
    protected $table = 'user_cart_collections';


    protected $fillable = ['cart_id', 'collection_id', 'price', 'quantity'];


    public function cart()
    {
        return $this->belongsTo('App\UserCart', 'cart_id');
    }
    public function cartItem ()
    {
        return $this->hasMany('App\UserCartItem', 'collection_id', 'collection_id');
    }

    public function collection ()
    {
        return $this->belongsTo('App\Collection', 'collection_id');
    }
}