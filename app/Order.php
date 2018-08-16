<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['transaction_id', 'user_id', 'cart_id', 'payment_type', 'total_price'];


    protected $table = 'orders';



    public function cart()
    {
        return $this->belongsTo('App\UserCart', 'cart_id');
    }

    public function user()
    {
        return  $this->belongsTo('App\User', 'user_id');
    }
}
