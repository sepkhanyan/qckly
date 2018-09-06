<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 'statuses';


    protected $fillable = [
        'status_name',
        'status_comment',
        'notify_customer',
        'status_for',
        'status_color'
    ];

}