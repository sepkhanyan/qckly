<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 'statuses';


    protected $fillable = [
        'name_en',
        'name_ar',
    ];


    public function order()
    {
        return $this->hasMany('App\Order', 'status_id');
    }


    public function orderRestaurant()
    {
        return $this->hasMany('App\OrderRestaurant', 'status_id');
    }
}
