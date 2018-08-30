<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'reviews';


    protected $fillable = ['order_id', 'restaurant_id', 'rate_value', 'review_text'];

    public function order()
    {
        return $this->belongsTo('App\Order', 'order_id');
    }

    public function restaurant()
    {
        return $this->belongsTo('App\Restaurant', 'restaurant_id');
    }
}
