<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mealtime extends Model
{
    protected $table = 'mealtimes';


    protected $fillable = [
        'name_en',
        'name_ar',
        'start_time',
        'end_time',
    ];

}
