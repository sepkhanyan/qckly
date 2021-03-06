<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderRestaurant extends Model
{
    protected $table = 'order_restaurant';


    protected $fillable = [
        'restaurant_id',
        'order_id',
        'price',
        'status_id'
    ];

    public function restaurant()
    {
        return $this->belongsTo('App\Restaurant', 'restaurant_id');
    }

    public function order()
    {
        return $this->belongsTo('App\Order', 'order_id');
    }


    public function status()
    {
        return $this->belongsTo('App\Status', 'status_id');
    }


    public function scopePriceAndOrderId($query, $val)
    {
        if (!empty($val)) {
            return $query->where('order_id', 'like', '%' . $val . '%')
                ->orWhere('total_price', 'like', '%' . $val . '%');
        }

        return $query;
    }
}
