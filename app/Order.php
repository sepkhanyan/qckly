<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';


    protected $fillable = [
        'transaction_id',
        'user_id',
        'cart_id',
        'payment_type',
        'total_price'
    ];


    public function cart()
    {
        return $this->belongsTo('App\UserCart', 'cart_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function review()
    {
        return $this->hasMany('App\Review', 'order_id');
    }

    public function status()
    {
        return $this->belongsTo('App\Status', 'status_id');
    }

    public function orderRestaurant()
    {
        return $this->hasMany('App\OrderRestaurant', 'order_id');
    }


    public function orderCollection()
    {
        return $this->hasMany('App\OrderCollection', 'order_id');
    }


    public function notification()
    {
        return $this->hasOne('App\Notification', 'order_id')->where('notification_type', 4);
    }
}
