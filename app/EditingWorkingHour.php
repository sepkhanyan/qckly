<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EditingWorkingHour extends Model
{
    protected $table = 'editing_working_hours';


    protected $fillable = [
        'weekday',
        'opening_time',
        'closing_time',
        'status',
        'type',
        'editing_restaurant_id'
    ];

    public function editingRestaurant()
    {
        return $this->belongsTo('App\EditingRestaurant', 'editing_restaurant_id');
    }
}
