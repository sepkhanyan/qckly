<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $fillable = ['sort', 'item', 'value', 'serialized'];



    protected $table = 'settings';
}
