<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';


    protected $fillable = [
        'sort',
        'item',
        'value',
        'serialized'
    ];

}
