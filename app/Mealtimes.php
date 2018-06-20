<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mealtimes extends Model
{
    protected $fillable = ['mealtime_name', 'start_time', 'end_time', 'mealtime_status'];


    protected $table = 'mealtimes';
}
