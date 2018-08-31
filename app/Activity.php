<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $table = 'activities';

    protected $fillable = [
        'domain',
        'context',
        'user',
        'user_id',
        'action',
        'message',
        'status',
        'date_added'
    ];

}
