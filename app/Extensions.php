<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Extensions extends Model
{
    protected $table = 'extensions';


    protected $fillable = [
        'type',
        'name',
        'data',
        'serialized',
        'status',
        'title',
        'version'
    ];

}
