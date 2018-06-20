<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permissions extends Model
{
    protected $fillable = ['name', 'description', 'action', 'status'];


    protected $table = 'permissions';
}
