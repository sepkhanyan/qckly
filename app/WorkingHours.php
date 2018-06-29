<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkingHours extends Model
{
    protected $table = 'working_hours';



    protected $fillable = ['weekday', 'opening_time', 'closing_time', 'status', 'type', 'restaurant_id'];


    public function restaurant()
    {
        return $this->belongsTo('App\Restaurant', 'restaurant_id', 'restaurant_id');
    }

}
