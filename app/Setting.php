<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['sort', 'item', 'value', 'serialized'];



    protected $table = 'settings';
}
