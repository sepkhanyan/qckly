<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mealtime extends Model
{
    protected $table = 'mealtimes';


    protected $fillable = [
        'mealtime_name',
        'start_time',
        'end_time',
        'mealtime_status'
    ];

}
