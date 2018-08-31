<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permalink extends Model
{
    protected $table = 'permalinks';


    protected $fillable = [
        'slug',
        'controller',
        'query'
    ];

}
