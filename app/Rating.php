<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $table = 'ratings';


    protected $fillable = ['order_id', 'restaurant_id', 'rate_value', 'review'];


    public function order()
    {
        return $this->belongsTo('App\Order', 'order_id');
    }

    public function restaurant()
    {
        return $this->belongsTo('App\Restaurant', 'restaurant_id');
    }
}
