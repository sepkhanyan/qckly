<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activities extends Model
{
    protected $fillable = ['domain', 'context', 'user', 'user_id', 'action', 'message', 'status', 'date_added'];


    protected $table = 'activities';
}
