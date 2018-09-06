<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MenuOption extends Model
{
    protected $table = 'menu_options';


    protected $fillable = [
        'option_id',
        'menu_id',
        'required',
        'default_value_id',
        'option_values'
    ];

}