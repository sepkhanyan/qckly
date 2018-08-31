<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
    protected $table = 'messages';


    protected $fillable = [
        'sender_id',
        'date_added',
        'send_type',
        'recipient',
        'subject',
        'body',
        'status'
    ];

}
