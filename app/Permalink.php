<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permalink extends Model
{
    protected $fillable = ['slug', 'controller', 'query'];


    protected $table = 'pages';
}
