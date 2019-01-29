<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCart extends Model
{
    protected $table = 'user_carts';


    protected $fillable = [
        'user_id',
        'delivery_order_area',
        'delivery_order_date',
        'delivery_order_time',
        'delivery_address_id',
        'completed',
    ];


    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }


    public function cartCollection()
    {
        return $this->hasMany('App\UserCartCollection', 'cart_id');
    }


    public function address()
    {
        return $this->belongsTo('App\Address', 'delivery_address_id');
    }


    public function order()
    {
        return $this->hasOne('App\Order', 'cart_id');
    }

    public function area()
    {
        return $this->belongsTo('App\Area', 'delivery_order_area');
    }

}
